<?php

namespace App\Models;

use App\Domains\Interfaces\IJobEntry;
use App\Mail\NewJobEntryMailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class JobEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const DEFAULT_DISK = 'public';
    public const DEFAULT_SAVE_PATH = 'resumes';

    public const SCHOOL_LEVELS = [
        'NÃO ALFABETIZADO',

        'ENSINO FUNDAMENTAL INCOMPLETO',
        'ENSINO FUNDAMENTAL COMPLETO',

        'ENSINO MEDIO INCOMPLETO',
        'ENSINO MEDIO COMPLETO',

        'ENSINO SUPERIOR INCOMPLETO',
        'ENSINO SUPERIOR COMPLETO',

        'POS GRADUACAO INCOMPLETA',
        'POS GRADUACAO COMPLETA',

        'MESTRADO INCOMPLETO',
        'MESTRADO COMPLETO',

        'DOUTORADO INCOMPLETO',
        'DOUTORADO COMPLETO',
    ];

    public static function createAndSendMail(array $data): void
    {
        $data['resume'] = JobEntry::storeResumeFile($data['resume']);
        $entry = self::create($data);
        $mail_data = $entry->getMailData();
        Mail::to('ekyidag@gmail.com')->send(new NewJobEntryMailable($mail_data));
    }

    private function getMailData(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'additional_info' => $this->additional_info,
            'resume_url' => $this->resume
        ];
    }

    private static function storeResumeFile($file): string
    {
        $name = $file->name ?? $file->getClientOriginalName();
        $storageUrl = Storage::disk(JobEntry::DEFAULT_DISK)->putFileAs(JobEntry::DEFAULT_SAVE_PATH, $file, $name);
        return asset('storage/' . $storageUrl);
    }
}
