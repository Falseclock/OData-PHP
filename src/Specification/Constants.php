<?php

namespace Falseclock\OData\Specification;

class Constants
{
    /** @var string Schema Namespace For Atom */
    const ATOM_NAMESPACE = 'http://www.w3.org/2005/Atom';

    //Schema Namespace for Atom Publishing Protocol.
    const APP_NAMESPACE = 'http://www.w3.org/2007/app';

    const METADATA_NAMESPACE_PREFIX = 'metadata';
    const METADATA_NAMESPACE = "http://docs.oasis-open.org/odata/ns/metadata";
    const METADATA_NAMESPACE_CONTEXT = "context";
    const METADATA_NAMESPACE_NAME = "name";

    //XML element name to mark 'service' element in APP.
    const ATOM_PUBLISHING_SERVICE_ELEMENT_NAME = 'service';

    // Schema Namespace prefix For xml.
    const XML_NAMESPACE_PREFIX = 'xml';

    //XML attribute value to indicate the base URI for a document or element.
    const XML_BASE_ATTRIBUTE_NAME = 'base';

    //XML element name to mark 'workspace' element in APP.
    const ATOM_PUBLISHING_WORKSPACE_ELEMNT_NAME = 'workspace';

    // Schema Namespace prefix For xmlns.
    const XMLNS_NAMESPACE_PREFIX = 'xmlns';

    //XML element name to mark title element in Atom.
    const ATOM_TITLE_ELEMENT_NAME = 'title';

    //XML element name to mark 'collection' element in APP.
    const ATOM_PUBLISHING_COLLECTION_ELEMENT_NAME = 'collection';

    //XML element name to mark href attribute element in Atom.
    const ATOM_HREF_ATTRIBUTE_NAME = 'href';

    /**
     * XML prefix for the Atom namespace.
     *
     * @var string
     */
    const ATOM_NAMESPACE_PREFIX = 'atom';

    /**
     * XML prefix for the Atom Publishing Protocol namespace
     *
     * @var string
     */
    const APP_NAMESPACE_PREFIX = 'app';
}