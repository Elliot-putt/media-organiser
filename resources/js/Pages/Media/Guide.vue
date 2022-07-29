<template>
    <Head>
        <title>Media Guide</title>
        <meta type="Media management" content="Information about my Media guide page" head-key="Media management guide">
    </Head>
    <div class="row justify-content-center">
        <div class="col-10 mt-3">
            <TitleLayout title="Media Guide"
                         description="This page will answer any question you might have with the media system!"/>
            <h3>How To navigate through media:</h3>
            <p>The Media is simple to navigate through with the intuitive onclick feature. If you would like to go into
                a folder click the folder icon this will direct you towards that directory!</p>
            <h3>How to View Files:</h3>
            <p>Files also use the one click method. If you would like to inspect/View a file click the file icon to
                proceed.</p>
            <h3>How to move files/folders:</h3>
            <p>To move files and folders within the media manager the select box under the desired media can be checked
                and a move option will appear which allows you to input a folder name in which to move the files and
                folder
                to. If you would like to move any media back to the top level when asked for a folder name please enter
                the word <strong>Media</strong> this will move all media to the top level.</p>
            <h3>How to delete files/folders:</h3>
            <p>To delete files and folders within the media manager the select box under the desired media can be
                checked
                and a delete option will appear which allows you to button to confirm this is the action you would like
                to complete. Confirm your actions and the media will be deleted.</p>
            <h3>How to upload files/folders:</h3>
            <p>To Upload files to the media manager you have two options:</p>
            <ol>
                <li>Drag and Drop</li>
                <li>Upload Modal</li>
            </ol>
            <p>To upload via drag and drop please drag your file from your device into the box until it highlights blue.
                When the effect has taken place please drop the file and this will upload!</p>
            <p>Secondly, please select the upload files button and click browse on the pop up. This will prompt the
                yourself to upload any files you would like to be stored. </p>

        </div>
    </div>
</template>

<script setup>
import TitleLayout from "../../Shared/TitleLayout";
</script>

