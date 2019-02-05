<?php

HTML::macro('attachments', function ($directory) {
    $files = Storage::disk('s3')->files($directory);
    $results = array();

    $list_html = '<ul class="list-group"><h4 class = "list-group-item-heading">Attachments</h4>';

    if (count($files) > 0) {
        foreach ($files as $file) {
            $list_html .= '<li class="list-group-item"><a href="'.config('filesystems.disks.s3.url').$file.'">'.basename($file).'</a></li>';
        }
    } else {
        $list_html .= ' <li class="list-group-item">No Attachments</li>';
    }


    $list_html .= '</ul>';

    return $list_html;
});
