<?php

$composer = require_once('../vendor/autoload.php');

use Falseclock\DBD\Common\Utils;
use Falseclock\DBD\Common\Utils as DBDUtils;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Constraint;
use Falseclock\DBD\Entity\Join;

require_once('./dbConnection.php');

$TABLE_NAME = "tender_lots";
$SCHEME_NAME = "tender";
$COLUMN_PREFIX = "tender_lot_";
$NAME_SPACE = "Tests\Entities";

$OVERRIDES = [
	'table' => [
		'tender_lots'       => 'TenderLot',
		'tenders_new'       => 'Tender',
		'categories'        => 'Category',
		'currencies'        => 'Currency',
		'delivery_entities' => 'DeliveryEntity',
		'measure_units'     => 'MeasureUnit',
		'tender_lot_states' => 'TenderLotState',
		'tender_lot_types'  => 'TenderLotType',
	],
];

/** @noinspection PhpUnhandledExceptionInspection */
$table = DBDUtils::tableStructure($db, $TABLE_NAME, $SCHEME_NAME);

// Set joins properly
foreach($table->constraints as $constraint) {
	if(!isset($constraint->join)) {

		$choices = [];

		$r = new ReflectionClass(Join::class);
		$constants = $r->getConstants();

		foreach($constants as $name => $value) {
			$choices[] = $value;
		}

		$choice = readStdin("Set how {$constraint->foreignTable->name}({$constraint->foreignColumn->name}) refers {$table->name}({$constraint->localColumn->name})",
							$choices
		);

		switch($choices[$choice]) {
			case Join::ONE_TO_ONE:
				$constraint->join = new Join\OneToOne();
				break;
			case Join::ONE_TO_MANY:
				$constraint->join = new Join\OneToMany();
				break;
			case Join::MANY_TO_ONE:
				$constraint->join = new Join\ManyToOne();
				break;
			case Join::MANY_TO_MANY:
				$constraint->join = new Join\ManyToMany();
				break;
			default:
				/** @noinspection PhpUnhandledExceptionInspection */
				throw new Exception("Unknown join type");
		}
	}
}

$foo = 1;

echo "<?php\n\n";
echo "namespace {$NAME_SPACE};\n\n";
echo "use Falseclock\DBD\Entity\Column;\n";
echo "use Falseclock\DBD\Entity\Constraint;\n";
echo "use Falseclock\DBD\Entity\Entity;\n";
echo "use Falseclock\DBD\Entity\Join;\n";
echo "use Falseclock\DBD\Entity\Mapper;\n";
echo "use Falseclock\DBD\Entity\Primitive;\n";

$entityName = getEntityName($TABLE_NAME,
							$OVERRIDES
); //isset($OVERRIDES['table'][$TABLE_NAME]) ? isset($OVERRIDES['table'][$TABLE_NAME]) : Utils::dashesToCamelCase($TABLE_NAME, true);

echo sprintf("\nclass %s extends Entity {\n", $entityName);
echo sprintf("const TABLE = \"%s\";\n", $TABLE_NAME);
echo sprintf("const SCHEME = \"%s\";\n", $SCHEME_NAME);
foreach($table->columns as $column) {
	$prefixLength = strlen($COLUMN_PREFIX);
	$columnName = Utils::dashesToCamelCase(substr($column->name, $prefixLength));
	if(strpos($column->name, $COLUMN_PREFIX) === 0) {

		echo sprintf("/**\n* %s \n*\n* @var %s\n* @see %sMap::%s */\n",
					 preg_replace('/\s\s+/', "; ", $column->annotation),
					 $column->type->getPhpVarType(),
					 $entityName,
					 $columnName
		);

		echo sprintf("public \$%s;\n", $columnName);
	}
}

foreach($table->constraints as $constraint) {
	$foreignTableName = getEntityName($constraint->foreignTable->name, $OVERRIDES);

	switch(true) {
		case $constraint->join instanceof Join\ManyToMany:
		case $constraint->join instanceof Join\OneToMany:
			echo sprintf("/** @var %s[] \$%s %s*/\npublic \$%s = [];\n", $foreignTableName, $foreignTableName, $constraint->foreignTable->annotation, $foreignTableName);
			break;
		case $constraint->join instanceof Join\ManyToOne:
		case $constraint->join instanceof Join\OneToOne:

			echo sprintf("/**\n* %s \n*\n* @var %s\n* @see %sMap::%s */\npublic $%s;\n",
						 preg_replace('/\s\s+/', "; ", $constraint->foreignTable->annotation),
						 $foreignTableName,
						 $entityName,
						 $foreignTableName,
						 $foreignTableName
			);
	}
}

echo "}\n\n";

$table->annotation = htmlspecialchars($table->annotation, ENT_COMPAT);
$table->annotation = str_replace([ "\r", "\\r" ], "", $table->annotation);
$table->annotation = str_replace("\\n", "\n", $table->annotation);
$table->annotation = preg_replace('/\s\s+/', "; ", $table->annotation);

echo sprintf("class %sMap extends Mapper {\n", getEntityName($TABLE_NAME, $OVERRIDES)); //Utils::dashesToCamelCase(, true));
echo sprintf("const ANNOTATION = \"%s\";\n", $table->annotation);

foreach($table->columns as $column) {
	$prefixLength = strlen($COLUMN_PREFIX);
	if(strpos($column->name, $COLUMN_PREFIX) === 0) {
		$columnName = Utils::dashesToCamelCase(substr($column->name, $prefixLength));
		echo sprintf("/** @see %s::%s */\n public \$%s = %s;\n", $entityName, $columnName, $columnName, getColumn($column));
	}
}

foreach($table->constraints as $constraint) {
	$varName = getEntityName($constraint->foreignTable->name, $OVERRIDES); // Utils::dashesToCamelCase($constraint->foreignTable->name, true);
	echo sprintf("/** @see %s::%s */\n protected \$%s = %s;\n", $entityName, $varName, $varName, getReference($constraint, $OVERRIDES));
}

foreach($table->columns as $column) {
	$prefixLength = strlen($COLUMN_PREFIX);
	if(strpos($column->name, $COLUMN_PREFIX) === false) {
		$columnName = Utils::dashesToCamelCase($column->name);
		echo sprintf("protected \$%s = %s;\n", $columnName, getColumn($column));
	}
}

echo "}\n";

function getReference(Constraint $constraint, $OVERRIDES) {
	$str = sprintf("[ Constraint::COLUMN => \"%s\"", $constraint->localColumn->name);
	$str .= sprintf(", Constraint::FOREIGN_SCHEME => \"%s\"", $constraint->foreignTable->scheme);
	$str .= sprintf(", Constraint::FOREIGN_TABLE => \"%s\"", $constraint->foreignTable->name);
	$str .= sprintf(", Constraint::FOREIGN_COLUMN => \"%s\"", $constraint->foreignColumn->name);
	/** @noinspection PhpUnhandledExceptionInspection */
	$str .= sprintf(", Constraint::JOIN_TYPE => Join::%s", $constraint->join->getConstantName());
	$str .= sprintf(", Constraint::BASE_CLASS => %s::class", getEntityName($constraint->foreignTable->name, $OVERRIDES));

	$str .= "]";

	return $str;
}

function getColumn(Column $column) {
	$str = sprintf("[ Column::NAME => \"%s\"", $column->name);
	$str .= sprintf(", Column::TYPE => Primitive::%s", $column->type->getValue());

	if(isset($column->defaultValue))
		$str .= sprintf(", Column::DEFAULT => \"%s\"", addcslashes($column->defaultValue, "\""));

	if(isset($column->nullable))
		$str .= sprintf(", Column::NULLABLE => %s", $column->nullable ? "true" : "false");

	if(isset($column->maxLength))
		$str .= sprintf(", Column::MAXLENGTH => %d", $column->maxLength);

	if(isset($column->scale))
		$str .= sprintf(", Column::SCALE => %s", $column->scale);

	if(isset($column->precision))
		$str .= sprintf(", Column::PRECISION => %s", $column->precision);

	if(isset($column->annotation))
		$str .= sprintf(", Column::ANNOTATION => \"%s\"", addcslashes(preg_replace('/\s\s+/', "; ", $column->annotation), "\""));

	if(isset($column->key) and $column->key === true)
		$str .= sprintf(", Column::KEY => %s", $column->key ? "true" : "false");

	if(isset($column->originType))
		$str .= sprintf(", Column::ORIGIN_TYPE => \"%s\"", $column->originType);

	$str .= "]";

	return $str;
}

function readStdin(string $prompt, iterable $inputs) {

	return 1;

	echo sprintf("%s\n", $prompt);
	foreach($inputs as $number => $value) {
		echo sprintf("  %d: %s\n", $number, $value);
	}

	$handle = fopen("php://stdin", "r") or die($php_errormsg);

	$line = intval(trim(fgets($handle)));

	if(!isset($inputs[$line])) {
		echo "WRONG choice!\n";
		readStdin($prompt, $inputs);
	}
	else {
		fclose($handle);
	}

	return $line;
}

function getEntityName($name, $override) {
	return isset($override['table'][$name]) ? $override['table'][$name] : Utils::dashesToCamelCase($name, true);
}