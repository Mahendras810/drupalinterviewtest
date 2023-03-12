<?php

class TestOverloading {
	function __call($name_of_function, $arguments) {
		if($name_of_function == 'area') {
			switch (count($arguments)) {
        case 1:
        return 3.14 * $arguments[0];
        case 2:
        return $arguments[0]*$arguments[1];
  		}
	  }
	}
}
$test_overloading = new TestOverloading;
echo($test_overloading->area(2));
echo "\n";
echo ($test_overloading->area(4, 2));

?>
