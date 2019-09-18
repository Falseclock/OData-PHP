<?php

namespace Falseclock\OData\Specification;

class Constants
{
	//Schema Namespace for Atom Publishing Protocol.
	const APP_NAMESPACE = 'http://www.w3.org/2007/app';
	// XML prefix for the Atom Publishing Protocol namespace
	const APP_NAMESPACE_PREFIX     = 'app';
	const ATOM_HREF_ATTRIBUTE_NAME = 'href';
	/** @var string Schema Namespace For Atom */
	const ATOM_NAMESPACE = 'http://www.w3.org/2005/Atom';
	// XML prefix for the Atom namespace.
	const ATOM_NAMESPACE_PREFIX                   = 'atom';
	const ATOM_PUBLISHING_COLLECTION_ELEMENT_NAME = 'collection';
	//XML element name to mark 'service' element in APP.
	const ATOM_PUBLISHING_SERVICE_ELEMENT_NAME = 'service';
	// Schema Namespace prefix For xml.
	const ATOM_PUBLISHING_WORKSPACE_ELEMNT_NAME = 'workspace';
	//XML attribute value to indicate the base URI for a document or element.
	const ATOM_TITLE_ELEMENT_NAME = 'title';
	//XML element name to mark 'workspace' element in APP.
	const DEFAULT_VALUE = "DefaultValue";
	// Schema Namespace prefix For xmlns.
	const EDMX_DATASERVICES_ELEMENT = 'DataServices';
	//XML element name to mark title element in Atom.
	const EDMX_ELEMENT = 'Edmx';
	//XML element name to mark 'collection' element in APP.
	const EDMX_NAMESPACE = 'http://docs.oasis-open.org/odata/ns/edmx';
	//XML element name to mark href attribute element in Atom.
	const EDMX_NAMESPACE_PREFIX = 'edmx';
	const EDMX_VERSION          = 'Version';
	const EDMX_VERSION_VALUE    = '4.0';
	const EDM_NAMESPACE         = 'http://docs.oasis-open.org/odata/ns/edm';
	// Prefix for Edmx Namespace in metadata document.
	const ENTITY_TYPE = 'EntityType';
	// Edmx Element Name in the metadata document.
	const MAX_LENGTH = 'MaxLength';
	// Edmx namespace in metadata document for version 1.0.
	const METADATA           = '$metadata';
	const METADATA_NAMESPACE = "http://docs.oasis-open.org/odata/ns/metadata";
	//Version attribute for the root Edmx Element in the metadata document.
	const METADATA_NAMESPACE_CONTEXT = "context";
	// Edmx DataServices Element Name in the metadata document.
	const METADATA_NAMESPACE_NAME = "name";
	//Value of the version attribute in the root edmx element in metadata document.
	const METADATA_NAMESPACE_PREFIX = 'metadata';
	// Schema Element Name in csdl.
	const NAME      = 'Name';
	//Namespace attribute Element Name in csdl.
	const NAMESPACE = 'Namespace';
	// EntityType Element Name in csdl.
	const NULLABLE = 'Nullable';
	//Name attribute Name in csdl.
	const PRECISION = 'Precision';
	// Property Element Name in csdl.
	const PROPERTY = 'Property';
	//Name attribute Name in csdl.
	const PROPERTY_NAME = 'Name';
	//Type attribute Name in csdl.
	const PROPERTY_TYPE = 'Type';
	//namespace for edm primitive types.
	const PROPERTY_TYPE_PREFIX = 'Edm.';
	const SCALE                = 'Scale';
	//MaxLength Facet Name in csdl.
	const SCHEMA = 'Schema';
	//Nullable Facet Name in csdl.
	const XMLNS_NAMESPACE_PREFIX = 'xmlns';
	//Precision Facet Name in csdl.
	const XML_BASE_ATTRIBUTE_NAME = 'base';
	//Scale Facet Name in csdl.
	const XML_NAMESPACE_PREFIX = 'xml';
	const ANNOTATION = "Annotation";
	const REFERENCE = "Reference";
	const REFERENCE_CORE_URI             = "http://docs.oasis-open.org/odata/odata/v4.0/errata03/os/complete/vocabularies/Org.OData.Core.V1.xml";
	const INCLUDE                        = "Include";
	const CORE_NAMESPACE                 = "Org.OData.Core.V1";
	const ALIAS                          = "Alias";
	const CORE_ALIAS                     = "Core";
	const CORE_REFERENCE_ANNOTATION_TERM = "Core.DefaultNamespace";
	const CORE_ANNOTATION_TERM           = "Core.Description";
	const TERM                           = "Term";
	const STRING                         = "String";
	const JSON_CSDL_VERSION              = "4.01";
	const KIND                           = "Kind";
	const SERVICE_DOCUMENT               = "service-document";
	// Key Element Name in csdl.
	const KEY = 'Key';
	// PropetyRef Element Name in csdl.
	const PROPERTY_REF = 'PropertyRef';
	const NAVIGATION_PROPERTY = "NavigationProperty";
	const PROPERTY_PARTNER = "Partner";
	const REFERENTIAL_CONSTRAINT = "ReferentialConstraint";
	const REFERENCED_PROPERTY = "ReferencedProperty";
}