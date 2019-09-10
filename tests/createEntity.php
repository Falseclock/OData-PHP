<?php

$composer = require_once('../vendor/autoload.php');

use Falseclock\DBD\Common\Utils;
use Falseclock\DBD\Entity\Column;

;

require_once('./dbConnection.php');

$TABLE_NAME = "tenders_new";
$SCHEME_NAME = "tender";
$COLUMN_PREFIX = "tender_";
$NAME_SPACE = "Tests\Entities";

$columns = $db->tableStructure($TABLE_NAME, $SCHEME_NAME);

$foo = 1;

echo "<?php\n\n";
echo "namespace {$NAME_SPACE};\n\n";
echo "use Falseclock\DBD\Entity\Column;\n";
echo "use Falseclock\DBD\Entity\Entity;\n";
echo "use Falseclock\DBD\Entity\Mapper;\n";
echo "use Falseclock\DBD\Entity\Primitive;\n";
echo sprintf("\nclass %s extends Entity {\n", Utils::dashesToCamelCase($TABLE_NAME, true));
echo sprintf("const TABLE = \"%s.%s\";\n", $SCHEME_NAME, $TABLE_NAME);
foreach($columns as $column) {
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
echo "}\n\n";

echo sprintf("class %sMap extends Mapper {\n", Utils::dashesToCamelCase($TABLE_NAME, true));
foreach($columns as $column) {
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

	$str .= "]";

	return $str;
}