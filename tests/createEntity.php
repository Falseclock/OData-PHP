<?php

$composer = require_once('../vendor/autoload.php');

use Falseclock\DBD\Common\Utils;
use Falseclock\DBD\Common\Utils as DBDUtils;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Join;

require_once('./dbConnection.php');

$TABLE_NAME = "tender_lots";
$SCHEME_NAME = "tender";
$COLUMN_PREFIX = "tender_lot_";
$NAME_SPACE = "Tests\Entities";

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

		$choice = readStdin("Set how {$constraint->foreignTable->name}({$constraint->foreignColumn->name}) refers {$table->name}({$constraint->column->name})",
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
echo "use Falseclock\DBD\Entity\Entity;\n";
echo "use Falseclock\DBD\Entity\Mapper;\n";
echo "use Falseclock\DBD\Entity\Primitive;\n";
echo sprintf("\nclass %s extends Entity {\n", Utils::dashesToCamelCase($TABLE_NAME, true));
echo sprintf("const TABLE = \"%s\";\n", $TABLE_NAME);
echo sprintf("const SCHEME = \"%s\";\n", $SCHEME_NAME);
foreach($table->columns as $column) {
	$prefixLength = strlen($COLUMN_PREFIX);
	if(strpos($column->name, $COLUMN_PREFIX) === 0) {
		$columnName = Utils::dashesToCamelCase(substr($column->name, $prefixLength));

		echo sprintf("/** @var %s \$%s %s */\n",
					 $column->type->getPhpVarType(),
					 $columnName,
					 preg_replace('/\s\s+/', "; ", $column->annotation)
		);

		echo sprintf("public \$%s;\n", $columnName);
	}
}
foreach($table->constraints as $constraint) {
	$foreignTableName = Utils::dashesToCamelCase($constraint->foreignTable->name, true);
	switch(true) {
		case $constraint->join instanceof Join\ManyToMany:
			echo sprintf("/** @var %s[] \$%s %s*/\npublic \$%s = [];\n", $foreignTableName, $foreignTableName, $constraint->foreignTable->annotation, $foreignTableName);
			break;
		case $constraint->join instanceof Join\ManyToOne:
		case $constraint->join instanceof Join\OneToMany:
		case $constraint->join instanceof Join\OneToOne:
			echo sprintf("/** @var %s \$%s %s*/\npublic \$%s;\n", $foreignTableName, $foreignTableName, $constraint->foreignTable->annotation, $foreignTableName);
			break;
	}
}
echo "}\n\n";

$table->annotation = htmlspecialchars($table->annotation, ENT_COMPAT);
$table->annotation = str_replace([ "\r", "\\r" ], "", $table->annotation);
$table->annotation = str_replace("\\n", "\n", $table->annotation);
$table->annotation = preg_replace('/\s\s+/', "; ", $table->annotation);

echo sprintf("class %sMap extends Mapper {\n", Utils::dashesToCamelCase($TABLE_NAME, true));
echo sprintf("const ANNOTATION = \"%s\";\n", $table->annotation);

foreach($table->columns as $column) {
	$prefixLength = strlen($COLUMN_PREFIX);
	if(strpos($column->name, $COLUMN_PREFIX) === 0) {
		$columnName = Utils::dashesToCamelCase(substr($column->name, $prefixLength));
		echo sprintf("public \$%s = %s;\n", $columnName, getColumn($column));
	}
}

echo "}\n";

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

	$str .= "]";

	return $str;
}

function readStdin(string $prompt, iterable $inputs) {
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