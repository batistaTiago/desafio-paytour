<?php

namespace Tests\Feature;

use App\Models\JobEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class SubmitJobEntryTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {

        parent::setUp();

        $this->withoutExceptionHandling([
            'Illuminate\Validation\ValidationException',
        ]);

        $this->followingRedirects();

        Storage::fake(JobEntry::DEFAULT_DISK);

        $this->headers = [
            'accept' => 'application/json',
        ];

        $this->good_file = UploadedFile::fake()->create('document.pdf', 1023, 'application/pdf'); // ate 1mb pode
        $this->bad_file = UploadedFile::fake()->create('document.pdf', 1025, 'application/pdf'); // mais de 1mb nao pode

        $this->doc_file = UploadedFile::fake()->create('document.doc', 1023, 'application/msword'); // arquivo .doc com 1023kb
        $this->docx_file = UploadedFile::fake()->create('document.docx', 1023, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'); // arquivo .docx com 1023kb

        $this->body = [
            'name' => 'test user',
            'email' => 'user@testing.com',
            'phone_number' => '5599345678912',
            'desired_role' => 'mid level backend engineer',
            'school_level' => 'ENSINO MEDIO INCOMPLETO',
            'additional_info' => Str::random(420),
        ];
    }

    /** @test */
    public function submit_job_entry_ok()
    {

        $this->assertCount(0, JobEntry::all());

        $file = $this->good_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(200);

        $this->assertCount(1, JobEntry::all());

        $entry = JobEntry::first();

        foreach ($this->body as $key => $value) {
            $this->assertEquals($entry->$key, $value);
        }

        Storage::disk(JobEntry::DEFAULT_DISK)->assertExists(JobEntry::DEFAULT_SAVE_PATH . '/' . $file->name);
    }

    /** @test */
    public function submit_job_entry_accepts_a_max_filesize_of_1_megabyte()
    {

        $this->assertCount(0, JobEntry::all());

        $file = $this->bad_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(422);

        $this->assertCount(0, JobEntry::all());

        Storage::disk(JobEntry::DEFAULT_DISK)->assertMissing(JobEntry::DEFAULT_SAVE_PATH . '/' . $file->name);
    }

    /** @test */
    public function submit_job_entry_additional_info_field_is_optional()
    {
        $this->assertCount(0, JobEntry::all());

        $file = $this->good_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
            'additional_info' => null,
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(200);

        $this->assertCount(1, JobEntry::all());
    }

    /** @test */
    public function submit_job_entry_ONLY_additional_info_field_is_optional()
    {

        $count = 0;

        $this->assertCount($count, JobEntry::all());

        $body_example = array_merge($this->body, [
            'resume' => $this->good_file,
            'additional_info' => null,
        ]);

        foreach ($body_example as $key => $value) {

            $post_data = $body_example;
            unset($post_data[$key]);

            $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

            if ($key !== 'additional_info') {
                $this->assertCount($count, JobEntry::all());
                $response->assertStatus(422);
            } else {
                $count++;
            }
        }
    }

    /** @test */
    public function submit_job_entry_school_level_validation()
    {
        $this->assertCount(0, JobEntry::all());

        $file = $this->good_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
            'school_level' => 'Some random thing',
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(422);

        $this->assertCount(0, JobEntry::all());
    }

    /** @test */
    public function submit_job_entry_stores_submission_date_and_request_ip()
    {
        $this->assertCount(0, JobEntry::all());

        $file = $this->good_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(200);

        $entry = JobEntry::first();

        $this->assertNotNull($entry->ip);
        $this->assertEquals('127.0.0.1', $entry->ip);

        $this->assertNotNull($entry->created_at);
    }

    /** @test */
    public function submit_job_entry_accepts_doc_files()
    {
        $this->assertCount(0, JobEntry::all());

        $file = $this->doc_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(200);

        $entry = JobEntry::first();

        $this->assertNotNull($entry->created_at);
    }

    /** @test */
    public function submit_job_entry_accepts_docx_files()
    {
        $this->assertCount(0, JobEntry::all());

        $file = $this->docx_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(200);

        $entry = JobEntry::first();

        $this->assertNotNull($entry->created_at);
    }

    /** @test */
    public function submit_job_entry_stores_file_as_url()
    {
        $this->assertCount(0, JobEntry::all());

        $file = $this->docx_file;
        $post_data = array_merge($this->body, [
            'resume' => $file,
        ]);

        $response = $this->post(route('job-entry.submit'), $post_data, $this->headers);

        $response->assertStatus(200);

        $entry = JobEntry::first();

        $this->assertStringContainsString('http', $entry->resume);
        $this->assertStringContainsString('storage/resumes', $entry->resume);
    }
}
