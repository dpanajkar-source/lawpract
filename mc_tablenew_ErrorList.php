<?php
require('includes/fpdfnew.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Header()
{
    // Select Arial bold 15
    $this->SetFont('Arial','BU',10);

    // Move to the right
  $this->Image('logo_main.png',230,10,50,0,'','', false, $maskImg);
    // Line break
    $this->Ln(20);
}
function Footer()
 { 
// Go to 1.5 cm from bottom 
$this->SetY(-15);
// Select Arial italic 8 
$this->SetFont('Arial','BI',8); 
// Print current and total page numbers 
$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

// $this->SetX( 235); 
 //$this->SetFont('','B','10');
 // $this->Cell(0,10,'Technologies Pvt. Ltd.',0,0,'C'); 

 }
		
	
	
	
function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
	{

		$this->AddPage('L','A4');
	$this->SetTextColor(255); 
	$this->SetFillColor(128,128,128);  
	$this->SetFont('','','10'); 
	$this->SetXY( 10, 30 ); 
	
	$this->Cell(12,7,"ID",1,0,'C',true); 
	$this->Cell(40,7,"Brief File",1,0,'C',true); 
	$this->Cell(30,7,"Court",1,0,'C',true); 
	$this->Cell(40,7,"Case No",1,0,'C',true); 
	$this->Cell(122,7,"Name Of Parties",1,0,'C',true); 
	
	$this->Cell(28,7,"Mobile",1,0,'C',true); 

	$this->SetTextColor(0); 
	
	$this->Ln(7);
	
	$this->SetFillColor(224,235,255); 
	$this->SetTextColor(0); 
	$this->SetFont(''); 
	
	$this->Cell(122,7,"",1,0,'C',False); 
		$this->Cell(11,7,"ID",1,0,'C',true);  
	$this->Cell(50,7,"Party",1,0,'C',true); 
		$this->Cell(11,7,"ID",1,0,'C',true); 
	$this->Cell(50,7,"Opposite Party",1,0,'C',true);
	$this->Cell(28,7,"",1,0,'C',False); 

	
	$this->Ln(); 

	
	}	
		
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}


//inserting class PDF_IMGALF FUNCTIONS BELOW
//Private properties
var $tmpFiles = array(); 

/*******************************************************************************
*                                                                              *
*                               Public methods                                 *
*                                                                              *
*******************************************************************************/
function Image($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='', $isMask=false, $maskImg=0)
{
	//Put an image on the page
	if(!isset($this->images[$file]))
	{
		//First use of this image, get info
		if($type=='')
		{
			$pos=strrpos($file,'.');
			if(!$pos)
				$this->Error('Image file has no extension and no type was specified: '.$file);
			$type=substr($file,$pos+1);
		}
		$type=strtolower($type);
		if($type=='png'){
			$info=$this->_parsepng($file);
			if($info=='alpha')
				return $this->ImagePngWithAlpha($file,$x,$y,$w,$h,$link);
		}
		else
		{
			if($type=='jpeg')
				$type='jpg';
			$mtd='_parse'.$type;
			if(!method_exists($this,$mtd))
				$this->Error('Unsupported image type: '.$type);
			$info=$this->$mtd($file);
		}
		if($isMask){
			if(in_array($file,$this->tmpFiles))
				$info['cs']='DeviceGray'; //hack necessary as GD can't produce gray scale images
			if($info['cs']!='DeviceGray')
				$this->Error('Mask must be a gray scale image');
			if($this->PDFVersion<'1.4')
				$this->PDFVersion='1.4';
		}
		$info['i']=count($this->images)+1;
		if($maskImg>0)
			$info['masked'] = $maskImg;
		$this->images[$file]=$info;
	}
	else
		$info=$this->images[$file];
	//Automatic width and height calculation if needed
	if($w==0 && $h==0)
	{
		//Put image at 72 dpi
		$w=$info['w']/$this->k;
		$h=$info['h']/$this->k;
	}
	elseif($w==0)
	
		$w=$h*$info['w']/$info['h'];
	elseif($h==0)
		$h=$w*$info['h']/$info['w'];
	//Flowing mode
	if($y===null)
	{
		if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
		{
			//Automatic page break
			$x2=$this->x;
			$this->AddPage($this->CurOrientation,$this->CurPageFormat);
			$this->x=$x2;
		}
		$y=$this->y;
		$this->y+=$h;
	}
	if($x===null)
		$x=$this->x;
	if(!$isMask)
		$this->_out(sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
	if($link)
		$this->Link($x,$y,$w,$h,$link);
	return $info['i'];
}

// needs GD 2.x extension
// pixel-wise operation, not very fast
function ImagePngWithAlpha($file,$x,$y,$w=0,$h=0,$link='')
{
	$tmp_alpha = tempnam('.', 'mska');
	$this->tmpFiles[] = $tmp_alpha;
	$tmp_plain = tempnam('.', 'mskp');
	$this->tmpFiles[] = $tmp_plain;

	list($wpx, $hpx) = getimagesize($file);
	$img = imagecreatefrompng($file);
	$alpha_img = imagecreate( $wpx, $hpx );

	// generate gray scale pallete
	for($c=0;$c<256;$c++)
		ImageColorAllocate($alpha_img, $c, $c, $c);

	// extract alpha channel
	$xpx=0;
	while ($xpx<$wpx){
		$ypx = 0;
		while ($ypx<$hpx){
			$color_index = imagecolorat($img, $xpx, $ypx);
			$col = imagecolorsforindex($img, $color_index);
			imagesetpixel($alpha_img, $xpx, $ypx, $this->_gamma( (127-$col['alpha'])*255/127) );
			++$ypx;
		}
		++$xpx;
	}

	imagepng($alpha_img, $tmp_alpha);
	imagedestroy($alpha_img);

	// extract image without alpha channel
	$plain_img = imagecreatetruecolor ( $wpx, $hpx );
	imagecopy($plain_img, $img, 0, 0, 0, 0, $wpx, $hpx );
	imagepng($plain_img, $tmp_plain);
	imagedestroy($plain_img);
	
	//first embed mask image (w, h, x, will be ignored)
	$maskImg = $this->Image($tmp_alpha, 0,0,0,0, 'PNG', '', true); 
	
	//embed image, masked with previously embedded mask
	$this->Image($tmp_plain,$x,$y,$w,$h,'PNG',$link, false, $maskImg);
}

function Close()
{
	parent::Close();
	// clean up tmp files
	foreach($this->tmpFiles as $tmp)
		@unlink($tmp);
}

/*******************************************************************************
*                                                                              *
*                               Private methods                                *
*                                                                              *
*******************************************************************************/
function _putimages()
{
	$filter=($this->compress) ? '/Filter /FlateDecode ' : '';
	reset($this->images);
	while(list($file,$info)=each($this->images))
	{
		$this->_newobj();
		$this->images[$file]['n']=$this->n;
		$this->_out('<</Type /XObject');
		$this->_out('/Subtype /Image');
		$this->_out('/Width '.$info['w']);
		$this->_out('/Height '.$info['h']);

		if(isset($info['masked']))
			$this->_out('/SMask '.($this->n-1).' 0 R');

		if($info['cs']=='Indexed')
			$this->_out('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal'])/3-1).' '.($this->n+1).' 0 R]');
		else
		{
			$this->_out('/ColorSpace /'.$info['cs']);
			if($info['cs']=='DeviceCMYK')
				$this->_out('/Decode [1 0 1 0 1 0 1 0]');
		}
		$this->_out('/BitsPerComponent '.$info['bpc']);
		if(isset($info['f']))
			$this->_out('/Filter /'.$info['f']);
		if(isset($info['parms']))
			$this->_out($info['parms']);
		if(isset($info['trns']) && is_array($info['trns']))
		{
			$trns='';
			for($i=0;$i<count($info['trns']);$i++)
				$trns.=$info['trns'][$i].' '.$info['trns'][$i].' ';
			$this->_out('/Mask ['.$trns.']');
		}
		$this->_out('/Length '.strlen($info['data']).'>>');
		$this->_putstream($info['data']);
		unset($this->images[$file]['data']);
		$this->_out('endobj');
		//Palette
		if($info['cs']=='Indexed')
		{
			$this->_newobj();
			$pal=($this->compress) ? gzcompress($info['pal']) : $info['pal'];
			$this->_out('<<'.$filter.'/Length '.strlen($pal).'>>');
			$this->_putstream($pal);
			$this->_out('endobj');
		}
	}
}

// GD seems to use a different gamma, this method is used to correct it again
function _gamma($v){
	return pow ($v/255, 2.2) * 255;
}

// this method overriding the original version is only needed to make the Image method support PNGs with alpha channels.
// if you only use the ImagePngWithAlpha method for such PNGs, you can remove it from this script.
function _parsepng($file)
{
	//Extract info from a PNG file
	$f=fopen($file,'rb');
	if(!$f)
		$this->Error('Can\'t open image file: '.$file);
	//Check signature
	if($this->_readstream($f,8)!=chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10))
		$this->Error('Not a PNG file: '.$file);
	//Read header chunk
	$this->_readstream($f,4);
	if($this->_readstream($f,4)!='IHDR')
		$this->Error('Incorrect PNG file: '.$file);
	$w=$this->_readint($f);
	$h=$this->_readint($f);
	$bpc=ord($this->_readstream($f,1));
	if($bpc>8)
		$this->Error('16-bit depth not supported: '.$file);
	$ct=ord($this->_readstream($f,1));
	if($ct==0)
		$colspace='DeviceGray';
	elseif($ct==2)
		$colspace='DeviceRGB';
	elseif($ct==3)
		$colspace='Indexed';
	else {
		fclose($f);      // the only changes are 
		return 'alpha';  // made in those 2 lines
	}
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown compression method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown filter method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Interlacing not supported: '.$file);
	$this->_readstream($f,4);
	$parms='/DecodeParms <</Predictor 15 /Colors '.($ct==2 ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w.'>>';
	//Scan chunks looking for palette, transparency and image data
	$pal='';
	$trns='';
	$data='';
	do
	{
		$n=$this->_readint($f);
		$type=$this->_readstream($f,4);
		if($type=='PLTE')
		{
			//Read palette
			$pal=$this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='tRNS')
		{
			//Read transparency info
			$t=$this->_readstream($f,$n);
			if($ct==0)
				$trns=array(ord(substr($t,1,1)));
			elseif($ct==2)
				$trns=array(ord(substr($t,1,1)), ord(substr($t,3,1)), ord(substr($t,5,1)));
			else
			{

				$pos=strpos($t,chr(0));
				if($pos!==false)
					$trns=array($pos);
			}
			$this->_readstream($f,4);
		}
		elseif($type=='IDAT')
		{
			//Read image data block
			$data.=$this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='IEND')
			break;
		else
			$this->_readstream($f,$n+4);
	}
	while($n);
	if($colspace=='Indexed' && empty($pal))
		$this->Error('Missing palette in '.$file);
	fclose($f);
	return array('w'=>$w, 'h'=>$h, 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'FlateDecode', 'parms'=>$parms, 'pal'=>$pal, 'trns'=>$trns, 'data'=>$data);
}


// PDF_ALF FUNCTIONS END HERE
}
?>
