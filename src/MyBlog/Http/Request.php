<?php

namespace MyBlog\Http;

class Request
{
    /**
     * @return RequestFile[]
     */
    public function getRequestFilesFromGlobals()
    {
        $request_files_to_return = [];

        foreach ($_FILES as $param_name => $entry) {
            if (is_array($entry['name'])) {
                $request_files = [];

                foreach ($entry['name'] as $param_name_key_name => $request_file_name) {
                    if ($request_file_name) {
                        $request_files[$param_name_key_name] = new RequestFile();
                    }
                }

                foreach ($entry['name'] as $param_name_key_name => $request_file_name) {
                    if (isset($request_files[$param_name_key_name])) {
                        $request_files[$param_name_key_name]->setName($request_file_name);
                    }
                }

                foreach ($entry['type'] as $param_name_key_name => $request_file_type) {
                    if (isset($request_files[$param_name_key_name])) {
                        $request_files[$param_name_key_name]->setType($request_file_type);
                    }
                }

                foreach ($entry['tmp_name'] as $param_name_key_name => $request_file_tmp_name) {
                    if (isset($request_files[$param_name_key_name])) {
                        $request_files[$param_name_key_name]->setTmpName($request_file_tmp_name);
                    }
                }

                foreach ($entry['error'] as $param_name_key_name => $request_file_error) {
                    if (isset($request_files[$param_name_key_name])) {
                        $request_files[$param_name_key_name]->setError($request_file_error);
                    }
                }

                foreach ($entry['size'] as $param_name_key_name => $request_file_size) {
                    if (isset($request_files[$param_name_key_name])) {
                        $request_files[$param_name_key_name]->setSize($request_file_size);
                    }
                }

                if (count($request_files) > 0) {
                    $request_files_to_return[$param_name] = $request_files;
                }

            } else {
                if ($entry['name']) {
                    $request_file = new RequestFile();
                    $request_file->setName($entry['name']);
                    $request_file->setType($entry['type']);
                    $request_file->setTmpName($entry['tmp_name']);
                    $request_file->setError($entry['error']);
                    $request_file->setSize($entry['size']);

                    $request_files_to_return[$param_name] = $request_file;
                }
            }
        }

        return $request_files_to_return;
    }
}