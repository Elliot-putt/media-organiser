<?php

namespace App\Http\Controllers;

use App\Jobs\FileUpload;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function PHPUnit\Framework\directoryExists;
use function PHPUnit\Framework\fileExists;

class MediaController extends Controller {

    public function index(Request $request)
    {
        $extension = $request->path ?? '';
        //second extension is taken as another wildcard maybe add as query string?
        $dir = Storage::disk('media');
        $path = $dir->path('/' . $extension);
        $files = Collection::empty();
        $folders = Collection::empty();

        foreach(File::files($path) as $file)
        {

            $data = [];
            $data['name'] = ucfirst($file->getFilename());
            $data['path'] = $file->getPath();
            $data['ext'] = $file->getExtension();
            $data['time'] = $file->getCTime();
            $data['type'] = $file->getType();
            $data['fullPath'] = Storage::disk('media')->url($extension . $file->getFilename());
            $files->push($data);
        }
        $relativeDirectories = [];
        foreach(Storage::directories('public/media/' . $extension) as $folder)
        {
            $offsetPath = str_replace(storage_path('app/'), '', $path);

            if(! str_ends_with($offsetPath, '/'))
            {
                $relativeDirectories[] = str_replace($offsetPath . '/', '', $folder);
                $folders->push(str_replace($offsetPath . '/', '', $folder));

            } else
            {
                $relativeDirectories[] = str_replace($offsetPath, '', $folder);
                $folders->push(str_replace($offsetPath, '', $folder));

            }
        }
        //Filter files within a path
        if($request->search)
        {
            // files search - filter by user search and update collections
            $files = $files->filter(function($item) {
                if(str_contains(strtolower($item['name']), strtolower(\Illuminate\Support\Facades\Request::input('search'))))
                {
                    return $item;
                } else
                {
                    return false;
                }
            })->values();
            //folder search - filter by user search and update collections
            $folders = $folders->filter(function($item) {
                if(str_contains(strtolower($item), strtolower(\Illuminate\Support\Facades\Request::input('search'))))
                {
                    return $item;
                } else
                {
                    return false;
                }
            })->values();
        }

        return Inertia::render('Media/View', [
            'directories' => $folders,
            'documents' => $files,
            'path' => $extension,
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }
    /////////////////////////////////////////////
    ///////////////Upload Media//////////////////
    /////////////////////////////////////////////
    public function upload(Request $request)
    {
//pass the directory they are currently in
        $path = '/' . $request->path;

        if($request->file('files') !== null)
        {

            foreach($request->file('files') as $file)
            {
                //in path add specific folder path
                Storage::disk('media')->putFileAs($path, $file, $file->getClientOriginalName());
            }

            //add optional parameter to add file directory extension
            return redirect('media/?path=' . $path);
        }
    }

    public function levelUp(Request $request)
    {
        $path = $request->path;

        if($path === null)
        {
            return redirect('/media');
        }

        if($path)
        {
            $lastDir = substr(strrchr(rtrim($path, '/'), '/'), 1);
            if($lastDir)
            {
                $path = str_replace('//', '/', str_replace($lastDir, '', $path));

            }
            if(! $lastDir)
            {
                return redirect('/media');
            }

//            //add optional parameter to add file directory extension
            return redirect('media/?path=' . $path);
        }

    }

    //checks if the folder already exits within a path
    public function checkFolder($folderName, Request $request)
    {
        $collection = Collection::empty();
        $extension = $request->path ?? '';
        //second extension is taken as another wildcard maybe add as query string?
        $dir = Storage::disk('media');
        $path = $dir->path('/' . $extension);
        if($folderName)
        {
            $relativeDirectories = [];
            foreach(Storage::directories('public/media/' . $extension) as $folder)
            {
                $offsetPath = str_replace(storage_path('app/'), '', $path);

                if(! str_ends_with($offsetPath, '/'))
                {
                    $relativeDirectories[] = str_replace($offsetPath . '/', '', $folder);

                } else
                {
                    $relativeDirectories[] = str_replace($offsetPath, '', $folder);

                }
            }
            if(! in_array($folderName, $relativeDirectories))
            {
                $collection->push($folderName);
            }

        } else
        {
            return false;
        }

        if($collection->count() === 1)
        {
            return $collection;

        } else
        {
            return false;
        }
    }

    public function createDir($folderName, Request $request)
    {
        $extension = $request->path ?? '';
        //second extension is taken as another wildcard maybe add as query string?
        $dir = Storage::disk('media');
        $path = $dir->path('/' . $extension);
        File::makeDirectory($path . '/' . $folderName);
    }

    //checks for a folder with this name anywhere in the application storage
    public function checkFolderAnywhere($dir)
    {
        $collection = Collection::empty();
        //if the request is media then we move it up to the top level
        if($dir === 'media')
        {
            $collection->push('media');
            $collection->push('media');
        }
        if($dir)
        {
            $userInput = str_replace(' ', '', $dir);

            foreach(Storage::disk('media')->allDirectories() as $folder)
            {
                if(str_contains($folder, '/'))
                {
                    //trim until we have no slashes and find folder
                    $lastDir = substr(strrchr(rtrim($folder, '/'), '/'), 1);
                    //check if both strings match
                    if($userInput == str_replace(' ', '', $lastDir))
                    {
                        $collection->push($lastDir);
                        $collection->push($folder);
                    }
                } else
                {

                    //check if both strings match 'folder' == 'folder'
                    if($userInput == str_replace(' ', '', $folder))
                    {
                        $collection->push($folder);
                        $collection->push($folder);
                    }
                }

            }
            if($collection->count() >= 1)
            {
                return $collection;
            }
        } else
        {
            return false;
        }


    }

    //moves all selected files to dir
    public function moveFiles(Request $request)
    {
        $extension = $request->path ?? '';
        //second extension is taken as another wildcard maybe add as query string?
        $dir = Storage::disk('media');
        $pathFrom = $dir->path('/' . $extension);
        $pathTo = $dir->path('/' . $request->dir);
        //if the request is media then we move it up to the top level
        if($request->dir === 'media')
        {

            foreach($request->filesDeleted as $fileName)
            {
                File::move($pathFrom . $fileName, $dir->path('/' . $fileName));
            }
            foreach($request->foldersDeleted as $folder)
            {
                File::moveDirectory($pathFrom . $folder, $dir->path('/' . $folder));
            }
        }
        if($request->dir !== 'media')
        {
            foreach($request->filesDeleted as $fileName)
            {
                File::move($pathFrom . $fileName, $pathTo . '/' . $fileName);
            }
            foreach($request->foldersDeleted as $folder)
            {
                File::moveDirectory($pathFrom . $folder, $pathTo . '/' . $folder);
            }
        }


    }

    public function fileDelete(Request $request)
    {
        $extension = $request->path ?? '';
        //second extension is taken as another wildcard maybe add as query string?
        $dir = Storage::disk('media');
        $path = $dir->path('/' . $extension);
        foreach($request->filesDeleted as $fileName)
        {
            File::delete($path . '/' . $fileName);
        }
        foreach($request->foldersDeleted as $folder)
        {
            Storage::disk('media')->deleteDirectory('/' . $extension . $folder);
        }

//        $dir = Storage::disk('media')->allDirectories();
//        dd('delete');
        return redirect('media/?path=' . $request->path);
    }

    public function guide()
    {
        return Inertia::render('Media/Guide');
    }

}
