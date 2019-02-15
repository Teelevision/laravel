<?php

namespace App\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\UriValidator;
use App\Routing\Matching\PageValidator;

class Route extends \Illuminate\Routing\Route
{

    /**
     * @var bool
     */
    protected $frontend = false;


    public static function getValidators()
    {
        if (isset(static::$validators)) {
            return static::$validators;
        }

        return static::$validators = static::replaceUriValidator(parent::getValidators());
    }

    protected static function replaceUriValidator(array $validators): array
    {
        foreach ($validators as $i => $validator) {
            if (get_class($validator) === UriValidator::class) {
                $validators[$i] = new PageValidator;
                break;
            }
        }
        return $validators;
    }

    public function bind(Request $request)
    {
        parent::bind($request);

        /**
         * Add all of the query parameters (except page) to the parameters.
         * This way the model binding works with query parameters.
         * Because we cannot have the model keys in the page parameter,
         * as I don't know how that could work.
         */
        $this->parameters = array_merge(
            $this->parameters,
            array_except($request->query->all(), 'page')
        );

        // TODO: if the query doesn't contain an id for the model binding, no error is thrown
        // TODO: if the query contains too many values, the route breaks

        return $this;
    }

    public function isFrontend(): bool
    {
        return $this->frontend;
    }

    public function frontend(bool $frontend = true)
    {
        $this->frontend = $frontend;
        return $this;
    }
}