<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="DocumentPostRequest"))
 */
class DocumentPostRequest
{
    protected $validator;

    protected $name;
    protected $file;
    protected $mime;
    protected $content;
    

    public function __construct($input)
    {
        $payload = $input::all();

        $this->validator = Validator::make($payload, [
            'document' => 'required|mimes:doc,docx,txt'
        ]);

        if ($this->validator->fails()) {
            throw new ValidationException($this->validator, $this->validator->errors());
        }

        $this->map($input::file('document'));
    }

    private function map($file)
    {
        $this->name = $file->getClientOriginalName();
        $this->content = file_get_contents($file->getRealPath());
        $this->mime = $file->getMimeType();
        $this->size = $file->getSize();
    }

    public function parse()
    {
        return [
            'document_name' => $this->name,
            'document_mime' => $this->mime,
            'document_size' => $this->size,
            'document_content' => $this->content
        ];
    }
}
