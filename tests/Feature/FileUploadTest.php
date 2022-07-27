<?php

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileUploadTest extends TestCase {

    public function test_File_Upload_Working()
    {
        ////////////////////////////////////////////
        /////// Test For upload Media /////////////
        ////////////////////////////////////////////
        $this->withoutExceptionHandling();
        $user = $this->login();
        $files = UploadedFile::fake()->image('img.png');
        $arr = [];
        $arr[] = $files;
        $path = '';
        $this->actingAs($user)->post(action([\App\Http\Controllers\MediaController::class, 'upload']), [
            'path' => $path,
            'files' => $arr,
        ])->assertRedirect('/media?path=/' . $path);
    }

}
