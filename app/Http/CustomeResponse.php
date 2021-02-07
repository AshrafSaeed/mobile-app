<?php

namespace App\Http;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Illuminate\Http\Response as BaseResponse;
use Illuminate\Validation\Validator;

class CustomeResponse extends BaseResponse
{

    protected $code;
    protected $data;
    protected $error;
    protected $status;

    /**
     * @param mixed $content
     * @param int $status
     * @param array $headers
     * @param null $code
     */
    public function __construct($content = '', $status = 200, array $headers = [], $code = null)
    {
        parent::__construct($content, $status, array_merge($headers, ['Content-Type' => 'application/json']));

        $this->code = $code;
        $this->formatContent();
    }

    public function formatContent()
    {
        $content = collect($this->original);

        $this->code = $this->code ?: $content->get('code', $this->statusCode);
        $this->status = $content->get('status', $this->isSuccessful());
        $this->data = $content->get('data', $this->isSuccessful() ? $this->original : []);
        $this->error = $content->get('error', $this->isSuccessful() ? [] : $this->original);

        if (!$this->shouldBeJson($this->error)) {
            $this->error = [$this->error];
        }

        $this->content = json_encode([
            'status' => $this->status,
            'data' => $this->data,
            'error' => $this->error,
            'code' => $this->code,
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getData()
    {
        return collect($this->data);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getError()
    {
        return collect($this->error);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @throws HaloValidationException
     */
    public function validate()
    {
        if ($this->isSuccessful()) {
            return $this;
        }

        /** @var Validator $validator */
        $validator = \Illuminate\Support\Facades\Validator::make([], []);

        $validator->after(function (Validator $validator) {
            foreach ($this->getError()->all() as $key => $value) {
                $validator->errors()->add($key, $this->flattenErrorMessages($value));
            }
        });

        if ($validator->fails()) {
            throw new HaloValidationException($validator, null);
        }

        return $this;
    }

    /**
     * Ensure validation messages are strings
     *
     * @param mixed $message
     *
     * @return string
     *
     */
    private function flattenErrorMessages($message)
    {
        $messageArray = [];

        foreach ((array)$message as $key => $value) {
            if (is_array($value)) {
                $messageArray[] = $this->flattenErrorMessages($value);
            } elseif (!is_numeric($key)) {
                $messageArray[] = sprintf('%s: %s', $key, $value);
            } else {
                $messageArray[] = $value;
            }
        }

        return implode(', ', array_filter($messageArray));
    }

    public static function fromLaravelResponse(BaseResponse $laravelResponse)
    {
        $content = $laravelResponse->getOriginalContent();

        if ($content instanceof Renderable) {
            throw new CannotReturnJsonException();
        }

        return new self($content, $laravelResponse->getStatusCode(), $laravelResponse->headers->all());
    }

    public static function fromLaravelJsonResponse(LaravelJsonResponse $laravelJsonResponse)
    {
        return new self($laravelJsonResponse->getData(true), $laravelJsonResponse->getStatusCode(), $laravelJsonResponse->headers->all());
    }

    public static function fromGuzzleResponse(ResponseInterface $guzzleResponse)
    {
        $stringContent = (string)$guzzleResponse->getBody();

        $content = json_decode($stringContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $content = $stringContent;
        }

        return new self($content, $guzzleResponse->getStatusCode(), $guzzleResponse->getHeaders());
    }
}
