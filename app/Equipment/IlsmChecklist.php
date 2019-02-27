<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;
use Storage;

class IlsmChecklist extends Model
{
    protected $table = 'ilsm_checklists';

    protected $fillable = ['ilsm_assessment_id','ilsm_id','answers','is_answered','is_compliant','date'];

    protected $casts = ['answers' => 'array'];

    protected $appends = ['is_compliant','attachments'];

    protected $dates = ['date'];

    public function ilsm()
    {
        return $this->belongsTo('App\Equipment\Ilsm', 'ilsm_id');
    }

    public function ilsmAssessment()
    {
        return $this->belongsTo('App\Equipment\IlsmAssessment', 'ilsm_assessment_id');
    }

    // public function setIsCompliantAttribute()
    // {
    //     if (empty($this->answers)) {
    //         return false;
    //     }

    //     foreach ($this->answers as $key => $answer) {
    //         if ($key != 'attachment' && $answer['answer'] == 'no') {
    //             return false;
    //         }
    //     }

    //     return true;
    // }

    public function getAttachmentsAttribute()
    {
        $attachments = [];

        if (empty($this->answers)) {
            return $attachments;
        }

        if (empty($this->answers['attachment'])) {
            return $attachments;
        }

        $files = Storage::disk('s3')->files($this->answers['attachment']);

        foreach ($files as $file) {
            $attachments[basename($file)] = config('filesystems.disks.s3.url').$file;
        }

        return $attachments;
    }
}
