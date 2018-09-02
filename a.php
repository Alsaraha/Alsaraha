<?php

define ( "O", 0 );
define ( "A", 1 );
define ( "E", 2 );


define ( "S", 0 );
define ( "D", 1 );
define ( "PI", 2 );
define ( "PM", 3 );
define ( "PF", 4 );

function normaled ( $word , $type , $double ) {
    if ($double) {
	$O = 'ٌ';
	if ((mb_substr($word, mb_strlen($word)-2, 1) === 'ا'
	  && mb_substr($word, mb_strlen($word)-2, 1) === 'ء') ||
	    mb_substr($word, mb_strlen($word)-1, 1) === 'ة')
	$A = '';
	else
	    $A = 'ا';

	$A .= 'ً';
	$E = 'ٍ';
    } else {
	$O = 'ُ';
	$A = 'َ';
	$E = 'ِ';
    }
    switch ($type) {
	case O:
	    return $word . $O;
	case A:
	    return $word . $A;
	case E:
	    return $word . $E;
    }
}

function normal ( &$word, &$double, &$O, &$A, &$E ) {
    if ($double) {
	$O = 'ٌ';
	if ((mb_substr($word, mb_strlen($word)-2, 1) === 'ا'
	  && mb_substr($word, mb_strlen($word)-2, 1) === 'ء') ||
	    mb_substr($word, mb_strlen($word)-1, 1) === 'ة')
	$A = '';
	else
	    $A = 'ا';
	$A .= 'ً';
	$E = 'ٍ';
    } else {
	$O = 'ُ';
	$A = 'َ';
	$E = 'ِ';
    }
}

function shape ( $word , $type ,
		 $position , $double=0 , $plural='' ) {
    switch ( $type ) {
	case S:
	    normal($word, $double, $O, $A, $E);
	    break;
	case D:
	    if (mb_substr($word,
			  mb_strlen($word)-1, 1)=== 'ة')
	    $word = mb_substr($word,
			      0,
			      mb_strlen($word) - 1) . 'ت';
	    $O = 'ان';
	    $A = 'ين';
	    $E = 'ين';
	    break;
	case PI:
	    $word = $plural;
	    normal($word, $double, $O, $A, $E);
	    break;
	case PM:
	    $O = 'ون';
	    $A = 'ين';
	    $E = 'ين';
	    break;
	case PF:
	    if (mb_substr($word,
			  mb_strlen($word)-1, 1)=== 'ة')
	    $word = mb_substr($word,
			      0,
			      mb_strlen($word) - 1);
	    $word = $word . "ات";
	    normal($word, $double, $O, $A, $E);
	    break;
    }
    switch ( $position ) {
	case O:
	    return $word . $O;
	case A:
	    return $word . $A;
	    break;
	case E:
	    return $word . $E;
	    break;
    }
}

function numshape ( $number , $word , $position, $pt, $p='' ) {
    if ( $number === 1 ) {
	return shape($word, S, $position, true);
    } if ($number === 2 ) {
	return shape($word, D, $position);
    } if ($number > 2 && $number < 11 ) {
	return shape($word, $pt, E, true, $p);
    } if ($number >= 11 && $number <= 99 ) {
	return shape($word, $p, A, true);
    } else {
	return shape($word, $p, E, true);
    }
}

function numm ( $number , $gender ) {
    if ( $gender ) {
	if ( $number == 8 )
	    $add = 'ية';
	else
	    $add = 'ة';
    } else {
	$add = '';
    }
    
    switch ($number) {
	case 3:
	    return 'ثلاث' . $add;
	case 4:
	    return 'أربع' . $add;
	case 5:
	    return 'خمس' . $add;
	case 6:
	    return 'ستّ' . $add;
	case 7:
	    return 'سبع' . $add;
	case 8:
	    return 'ثمان' . $add;
	case 9:
	    return 'تسع' . $add;
	case 10:
	    return 'عشر' . $add;
    }
}

function numt ($number, $gender) {
    $units = $number % 10;
    if ($units == 1) {
	if ($gender)
	    $a = 'إحدى';
	else
	    $a = 'أحدَ';
    } else if ($units == 2 ) {
	if ($gender)
	    $a = 'اثنتى';
	else
	    $a = 'اثنى';
    } else {
	$a = numm($units, !$gender);
	normal($a, $double, $O, $A, $E);
	$a = $a . $A;
    }
    if ($gender)
	$b = 'عشرة';
    else
	$b = 'عشر';
    $double = 0;
    normal($b, $double, $O, $A, $E);
    $b = $b . $A;
    return $a . ' ' . $b;
}

function numd ($number, $position) {
    if ($number==2) {
	$n = 'عشر';
    } else {
	$n = numm ($number, 0);
    }
    $a = '';
    switch ($position) {
	case O:
	    $a = 'ون';
	    break;
	case A:
	    $a = 'ين';
	    break;
	case E:
	    $a = 'ين';
	    break;
    }
    return $n . $a;
}

function l99($number, $gender, $position) {
    $units = $number%10;
    $tens = floor($number/10);
    if ($units==1) {
	if ($gender)
	    $u = 'واحدة';
	else
	    $u = 'واحد';
    } else {
	$u = numm($units, !$gender);
    }
    if ($units==2) {
	if ($gender) {
	    if ($position == O)
		$a = 'اثنتانِ';
	    else
		$a = 'اثنتينِ';
	} else {
	    if ($position == O)
		$a = 'اثنانِ';
	    else
		$a = 'اثنينِ';
	}
    } else {
	$a = normaled($u, $position, true);
    }
    $b = numd($tens, $position);
    return $a . ' و'. $b;
}

function ll ($thing, $type, $number, $gender, $position, $pi, $ow=null) {
    if ($number<=10) {
	if ($number==0) return '';
	if ($number==1) {
	    return shape($thing, $ow || S, $position, true, '');
	}
	if ($number==2) {
	    return shape($thing, $ow || D, $position, true, '');
	}
	if ($ow === null)
	    $ow = $type;
	return normaled(numm($number, $gender), $position, false)
	     . ' ' . shape($thing, $ow, E, true, $pi);
    } else if ($number<=19) {
	return numt($number, !$gender)
	     . ' ' . shape($thing, $ow || S, A, true, $pi);
    } else if ($number <=99 && $number%10 == 0) {
	return numd($number/10, $position)
	     . ' ' . shape($thing, $ow || S, A, true, $pi);
    } else if ($number<=99) {
	return l99($number, !$gender, $position)
	     . ' ' . shape($thing, $ow || S, A, true, $pi);
    } else if ($number<=999) {
	$a = $number%100;
	$b = ($number-$a)/100;
	switch ($b) {
	    case 1:
		$c = 'مائة';
		break;
	    case 2:
		$c = 'مئتان';
		break;
	    case 3:
		$c = 'ثلاثمائة';
		break;
	    case 4:
		$c = 'أربعمائة';
		break;
	    case 5:
		$c = 'خمسمائة';
		break;
	    case 6:
		$c = 'ستمائة';
		break;
	    case 7:
		$c = 'سبعمائة';
		break;
	    case 8:
		$c = 'ثمانمائة';
		break;
	    case 9:
		$c = 'تسعمائة';
		break;
	    default:
		$c = normaled(numm($b, TRUE), $position, false);
	}

	if ($a!=0) {
	    $x = ll ($thing, $type, $a, $gender, $position, $pi);
	    if ($b == 2) {
		return shape($c, S, E, true) .' و' . $x;
	    } else {
		return shape($c, S, $position, true) .' و' . $x;
	    }
	} else {
	    if ($b == 2) {
		return 'مائتا' .
		       ' ' . shape($thing, $ow || S, $position, true, $pi);
	    } else {
		return shape($c, S, E, false) .
		       ' ' . shape($thing, $ow || S, $position, true, $pi);
	    }
	}
    }
}

$i = 7;

function mm ($thing, $type, $number, $gender, $position, $pi, $ow=null) {
    $i = $number;
    echo 'قرأتُ ';
    $j = $i%1000000;
    $k = floor($i/1000000);
    if ($k>=1 && $k<=999) {
	echo ll('مليون',
		PI,
		$k, true, A, 'ملايين');
	echo ' و';
    }
    $j = $i%1000;
    $k = floor($i/1000);
    if ($k>=1 && $k<=999) {
	echo ll('ألف',
		PI,
		$k, true, A, 'آلاف');
	if ($number%10==0) {
	    echo ' ';
	    echo normaled($thing, $position, true);
	} else {
	    echo ' و';
	}
    }
    //echo $number%1000;
    echo ll($thing, $type, $number%1000, $gender, $position, $pi, $ow) . '<br>';
    echo '<br>';
}

$j = isset($_GET['j']) ? $_GET['j'] || 300 : 300;
for ($j=0; $j<=1000; $j+=100) {
    mm('كتاب',
       PI,
       $j, true, A, 'كتب') . '<br>';
}


//echo normaled(numm(10, TRUE), O, false);
//echo numt(13, 1);

//echo numshape(5, 'موقن', O, PM);

//echo shape("كراسة", D, O, true, '');

die();
function fem0($number) {
    return $number . "ة";
}
function form($number, $type, $gender, $position) {
    $add='';
    switch ($gender) {
	    // MALE
	case 0:
	    switch ($type) {
		case 0:
		    // NORMAL
		    switch ($position) {
			case 0:
			    $add .= 'ُ';
			    break;
			case 1:
			    $add .= 'ِ';
			    break;
			case 2:
			    $add .= 'َ';
			    break;
		    }
		    break;
		case 1:
		    // NORMAL
		    switch ($position) {
			case 0:
			    $add .= 'ان';
			    break;
			case 1:
			    $add .= 'ين';
			    break;
			case 2:
			    $add .= 'ين';
			    break;
		    }
		    break;
		case 2:
		    // NORMAL
		    switch ($position) {
			case 0:
			    $add .= 'ُ';
			    break;
			case 1:
			    $add .= 'ِ';
			    break;
			case 2:
			    $add .= 'َ';
			    break;
		    }
		    break;
		case 3:
		    // NORMAL
		    switch ($position) {
			case 0:
			    $add .= 'ُ';
			    break;
			case 1:
			    $add .= 'ِ';
			    break;
			case 2:
			    $add .= 'َ';
			    break;
		    }
		    break;
	    }
	    break;
	    // FEMALE
	case 1:
	    switch ($type) {
		case 0:
		    // NORMAL
		    $add .= 'ة';
		    switch ($position) {
			case 0:
			    $add .= 'ُ';
			    break;
			case 1:
			    $add .= 'ِ';
			    break;
			case 2:
			    $add .= 'َ';
			    break;
		    }
		    break;
		case 1:
		    // NORMAL
		    switch ($position) {
			case 0:
			    $add .= 'تان';
			    break;
			case 1:
			    $add .= 'تين';
			    break;
			case 2:
			    $add .= 'تين';
			    break;
		    }
		    break;
		case 2:
		    // NORMAL
		    switch ($position) {
			case 0:
			    $add .= 'يةُ';
			    break;
			case 1:
			    $add .= 'يةِ';
			    break;
			case 2:
			    $add .= 'يةَ';
			    break;
		    }
		    break;
		case 3:
		    // NORMAL
		    $add .= 'ة';
		    switch ($position) {
			case 0:
			    $add .= 'ُ';
			    break;
			case 1:
			    $add .= 'ِ';
			    break;
			case 2:
			    $add .= 'َ';
			    break;
		    }
		    break;
	    }
	    break;
    }
    return $number.$add;
}

function nform($number, $gender, $position) {
    switch ($number) {
	case 1:
	    $n = 'واحد';
	    $t = 0;
	    break;
	case 2:
	    $n = 'اثن';
	    $t = 1;
	    break;
	case 3:
	    $n = 'ثلاث';
	    $t = 0;
	    break;
	case 4:
	    $n = 'أربع';
	    $t = 0;
	    break;
	case 5:
	    $n = 'خمس';
	    $t = 0;
	    break;
	case 6:
	    $n = 'ست';
	    $t = 0;
	    break;
	case 7:
	    $n = 'سبع';
	    $t = 0;
	    break;
	case 8:
	    $n = 'ثمان';
	    $t = 2;
	    break;
	case 9:
	    $n = 'تسع';
	    $t = 0;
	    break;
	case 10:
	    $n = 'عشر';
	    $t = 0;
	    break;
	default:
	    return $number;
    }
    return form($n, $t, $gender, $position);
}

function comb($number, $gender) {
    $g1 = !$gender;
    $g2 = $gender;
    $n1 = $number-10;
    switch ($n1) {
	case 1:
	    $g1 = $gender;
	    switch ($g1) {
		case 0:
		    $m = 'أحدَ';
		    break;
		case 1:
		    $m = 'إحدى';
		    break;
	    }
	    break;
	case 2:
	    $g1 = $gender;
	    switch ($g1) {
		case 0:
		    $m = 'اثنى';
		    break;
		case 1:
		    $m = 'اثنتى';
		    break;
	    }
	    break;
	default:
	    $m = nform($n1, $g1, 2);
    }
    return $m . " " . nform(10, $g2, 2);
}

function tens($number, $gender, $position) {
    $units = $number%10;
    $tens = floor($number/10);
    $base = '';
    switch ($tens) {
	case 2:
	    $base = 'عشر';
	    break;
	case 3:
	    $base = 'ثلاث';
	    break;
	case 4:
	    $base = 'أربع';
	    break;
	case 5:
	    $base = 'خمس';
	    break;
	case 6:
	    $base = 'ست';
	    break;
	case 7:
	    $base = 'سبع';
	    break;
	case 8:
	    $base = 'ثمان';
	    break;
	case 9:
	    $base = 'تسع';
	    break;
    }
    switch ($position) {
	case 0:
	    $base .= 'ون';
	    break;
	case 1:
	    $base .= 'ين';
	    break;
	case 2:
	    $base .= 'ين';
	    break;
    }
    return nform($units, $gender, $position) . ' و' . $base;
}

for ($i=20; $i<100; $i++)
    echo tens($i, 0, 0) . ' كتاباً' . '<br/>';


function ztn($number, $gender) {
    switch ($number) {
	case 0:
	    break;
	case 1:
	    break;
	case 2:
	    break;
	case 3:
	    break;
	case 4:
	    break;
	case 5:
	    break;
	case 6:
	    break;
	case 7:
	    break;
	case 8:
	    break;
	case 9:
	    break;
    }
}
?>
