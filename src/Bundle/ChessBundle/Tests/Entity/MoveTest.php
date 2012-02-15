<?php


namespace Bundle\ChessBundle\Tests\Entity;

use Bundle\ChessBundle\Entity\Move;

class MoveTest extends \PHPUnit_Framework_TestCase{
	public function testMove(){
		$board = array(
			'a8' => 9820,
			'b8' => 9822,
			'c8' => 9821,
			'd8' => 9819,
			'e8' => 9818,
			'f8' => 9821,
			'g8' => 9822,
			'h8' => 9820,
			
			'a7' => 9823,
			'b7' => 9823,
			'c7' => 9823,
			'd7' => 9823,
			'e7' => 9823,
			'f7' => 9823,
			'g7' => 9823,
			'h7' => 9823,
			
			'a6' => 0,
			'b6' => 0,
			'c6' => 0,
			'd6' => 0,
			'e6' => 0,
			'f6' => 0,
			'g6' => 0,
			'h6' => 0,
			
			'a5' => 0,
			'b5' => 0,
			'c5' => 0,
			'd5' => 0,
			'e5' => 0,
			'f5' => 0,
			'g5' => 0,
			'h5' => 0,
			
			'a4' => 0,
			'b4' => 0,
			'c4' => 0,
			'd4' => 0,
			'e4' => 0,
			'f4' => 0,
			'g4' => 0,
			'h4' => 0,
			
			'a3' => 0,
			'b3' => 0,
			'c3' => 0,
			'd3' => 0,
			'e3' => 0,
			'f3' => 0,
			'g3' => 0,
			'h3' => 0,

			'a2' => 9817,
			'b2' => 9817,
			'c2' => 9817,
			'd2' => 9817,
			'e2' => 9817,
			'f2' => 9817,
			'g2' => 9817,
			'h2' => 9817,

			'a1' => 9814,
			'b1' => 9816,
			'c1' => 9815,
			'd1' => 9813,
			'e1' => 9812,
			'f1' => 9815,
			'g1' => 9816,
			'h1' => 9814,
		);
		
		$move = new Move($board, "w", "A2-A3");
		
		$this->assertEquals($move->negativToZero(0), 0);
		$this->assertTrue($move->checkTo());
	}
}