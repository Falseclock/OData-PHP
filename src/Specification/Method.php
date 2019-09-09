<?php

namespace Falseclock\OData\Specification;

class Method
{
    /** @var string Remove the resource. */
    const DELETE = "DELETE";
    /** @var string Get the resource (a collection of entities, a single entity, a structural property, a navigation property, a stream, etc.). */
    const GET = "GET";
    /** @var string Update an existing resource by replacing part of its properties with a partial instance. */
    const PATCH = "PATCH";
    /** @var string Create a new resource. */
    const POST = "POST";
    /** @var string  Update an existing resource by replacing it with a complete instance. */
    const PUT = "PUT";
}