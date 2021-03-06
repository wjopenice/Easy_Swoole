<?php

namespace EasySwoole\Oss\Tencent;

use EasySwoole\Oss\Tencent\Exception\CosException;
use EasySwoole\Oss\Tencent\Exception\OssException;
use EasySwoole\Oss\Tencent\Exception\ServiceResponseException;
use EasySwoole\Spl\SplStream;

class MultipartUpload {
    /**
     * const var: part size from 1MB to 5GB, and max parts of 10000 are allowed for each upload.
     */
    const MIN_PART_SIZE = 1048576;
    const MAX_PART_SIZE = 5368709120;
    const DEFAULT_PART_SIZE = 52428800;
    const MAX_PARTS     = 10000;

    /**
     * @var $client OssClient
     */
    private $client;
    /**
     * @var $body SplStream
     */
    private $body;
    private $options;
    private $partSize;

    public function __construct($client, $body, $options = array()) {
        $this->client = $client;
        $this->body = $body;
        $this->options = $options;
        $this->partSize = $this->calculatePartSize($options['PartSize']);
        unset($options['PartSize']);
    }

    public function performUploading() {
        $rt = $this->initiateMultipartUpload();
        $uploadId = $rt['UploadId'];
        $partNumber = 1;
        $parts = array();
        for (;;) {
            if ($this->body->eof()) {
                break;
            }
            $body = $this->body->read($this->partSize);
            if (empty($body)) {
                break;
            }
            $result = $this->client->uploadPart(array(
                        'Bucket' => $this->options['Bucket'],
                        'Key' => $this->options['Key'],
                        'Body' => $body,
                        'UploadId' => $uploadId,
                        'PartNumber' => $partNumber));

            if (md5($body) != substr($result['ETag'], 1, -1)){
                throw new ServiceResponseException("ETag check inconsistency");
            }
            $part = array('PartNumber' => $partNumber, 'ETag' => $result['ETag']);
            array_push($parts, $part);
            ++$partNumber;
        }
        try {
            $rt = $this->client->completeMultipartUpload(array(
                'Bucket' => $this->options['Bucket'],
                'Key' => $this->options['Key'],
                'UploadId' => $uploadId,
                'Parts' => $parts));
        } catch(\Exception $e){
            throw $e;
        }
        return $rt;
    }

    public function resumeUploading() {
        $uploadId = $this->options['UploadId'];
        $rt = $this->client->ListParts(
            array('UploadId' => $uploadId,
                'Bucket'=>$this->options['Bucket'],
                'Key'=>$this->options['Key']));
                $parts = array();
        if (count($rt['Parts']) > 0) {
            foreach ($rt['Parts'] as $part) {
                if (empty($part)){
                    continue;
                }
                $parts[$part['PartNumber'] - 1] = array('PartNumber' => $part['PartNumber'], 'ETag' => $part['ETag']);
            }
        }
        for ($partNumber = 1;;++$partNumber) {
            if ($this->body->eof()) {
                break;
            }
            $body = $this->body->read($this->partSize);

            if (array_key_exists($partNumber-1, $parts)){

                if (md5($body) != substr($parts[$partNumber-1]['ETag'], 1, -1)){
                    throw new OssException("ETag check inconsistency");
                }
                continue;
            }

            $result = $this->client->uploadPart(array(
                'Bucket' => $this->options['Bucket'],
                'Key' => $this->options['Key'],
                'Body' => $body,
                'UploadId' => $uploadId,
                'PartNumber' => $partNumber));
            if (md5($body) != substr($result['ETag'], 1, -1)){
                throw new CosException("ETag check inconsistency");
            }
            $parts[$partNumber-1] = array('PartNumber' => $partNumber, 'ETag' => $result['ETag']);

        }
        $rt = $this->client->completeMultipartUpload(array(
            'Bucket' => $this->options['Bucket'],
            'Key' => $this->options['Key'],
            'UploadId' => $uploadId,
            'Parts' => $parts));
        return $rt;
    }

    private function calculatePartSize($minPartSize) {
        $partSize = intval(ceil(($this->body->getSize() / self::MAX_PARTS)));
        $partSize = max($minPartSize, $partSize);
        $partSize = min($partSize, self::MAX_PART_SIZE);
        $partSize = max($partSize, self::MIN_PART_SIZE);

        return $partSize;
    }

    private function initiateMultipartUpload() {
        $result = $this->client->createMultipartUpload($this->options);
        return $result;
    }
}
