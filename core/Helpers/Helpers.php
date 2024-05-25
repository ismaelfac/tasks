<?php


use Illuminate\Support\Facades\Auth;

function getRequestServerName($request): bool
{
    return $request->server('SERVER_NAME') === '127.0.0.1' || $request->server('SERVER_NAME') === 'devapi.taschedule.com';
}

function storageFile($file, $folder)
{
    $ext = $file->clientExtension();
    $file_name = rand().'.'.$ext;
    $path = \Storage::disk("local")->putFileAs("", $file, "$folder/".$file_name);
    return $path;
}

function checkUserAuth() {
    if (Auth::check()) {
        return Auth::user()->id;
    } else {
        return env("USER_IMPORT");
    }
}
