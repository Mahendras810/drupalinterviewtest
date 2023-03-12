<?php
class ParentClass {
  private function testoverriding() {
 echo "This is baseclass method";
  }
}
 class ChildClass extends ParentClass {
  public function testoverriding() {
  echo "This is overriding class method";
  }
 }
  $object = new childClass;
  $object->testoverriding()

?>
