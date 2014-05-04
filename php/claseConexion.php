<?php 

class Conexion{

	public $localhost;
	public $usuario;
	public $password;
	public $basedatos;
	//Recibe los datos necesarios para iniciar sesion en el server, crear la base de datos y seleccionarla
	function __construct($l, $u, $p, $db) {
		$this->localhost = $l;
		$this->usuario = $u;
		$this->password = $p;
		$this->basedatos = $db;
	}
	//Funcion que conectar con el servidor
	function conectarServidor(){
		if(mysql_connect($this->localhost, $this->usuario, $this->password)){
			return true;
		}else{
			return false;
		}
	}
	//Funcion que crea la base de datos
    function crearBasedatos(){
        if(mysql_query("create database $this->basedatos")){
            echo $this->basedatos.' creada con exito<br/>';
        }else{
            echo 'No se ha podido crear la base de datos<br/>';
        }
    }
    //Funcion que selecciona la base de datos
	function seleccionarBaseDatos(){
		if(mysql_select_db($this->basedatos)){
            return true;
		}else{
            return false;
		}
	}
	//Funcion que nos crea las tablas necesarias para la web
    function crearTablas(){
        session_start();
        $usuarios = 'CREATE TABLE usuarios(
                    nombre Varchar(255),
                    apellidos Varchar(255),
                    fechanacimiento Date,
                    provincia Varchar(255),
                    telefono Varchar(12),
                    calendario Varchar(255),
                    email Varchar(255) NOT NULL,
                    usuario Varchar(255) NOT NULL,
                    password Varchar(255) NOT NULL,
                    user_hash Varchar(255) NOT NULL,
                    tempcode Varchar(255),
                    PRIMARY KEY (usuario))';
        $etiquetas = 'CREATE TABLE etiquetas(
                    etiqueta Varchar(255) NOT NULL,
                    usuario Varchar(255) NOT NULL,
                    color Varchar(255),
                    PRIMARY KEY (etiqueta,usuario),
                    FOREIGN KEY (usuario) REFERENCES usuarios (usuario))';
        $calendarios = 'CREATE TABLE calendarios(
                    nombrecal Varchar(255) NOT NULL,
                    usuario Varchar(255) NOT NULL,
                    PRIMARY KEY (nombrecal,usuario),
                    FOREIGN KEY (usuario) REFERENCES usuarios (usuario))';
        $eventos = 'CREATE TABLE eventos(
                    idevento Int NOT NULL AUTO_INCREMENT,
                    usuario Varchar(255) NOT NULL,
                    titulo Varchar(255),
                    etiqueta Varchar(255),
                    ano Varchar(255),
                    mes Varchar(255),  
                    dia Varchar(255),
                    horai Varchar(255), 
                    horaf Varchar(255),
                    fechai Date,
                    fechaf Date,
                    nombrecal Varchar(255),
                    observaciones Varchar(255),
                    recordar Varchar(10),
                    PRIMARY KEY (idevento,usuario),
                    FOREIGN KEY (usuario) REFERENCES usuarios (usuario),
                    FOREIGN KEY (nombrecal) REFERENCES calendarios (nombrecal))';
        $colores = 'CREATE TABLE colores(
                    id_color Int(11) NOT NULL,
                    codigo_color Varchar(255) NOT NULL,
                    PRIMARY KEY (id_color))';
		//Una ves creadas las tablas, nos introduce todos los coleres de nuestra paleta de colores.
        if(mysql_query($usuarios) && mysql_query($etiquetas) && mysql_query($calendarios) && mysql_query($eventos) && mysql_query($colores)){
            $_SESSION['tablas'] = 'Tablas creadas con exito.';

            $codigosdecolor = array ('0'=>"color0",'1'=>"color1",'2'=>"color2",'3'=>"color3",'4'=>"color4",'5'=>"color5",'6'=>"color6",'7'=>"color7",'8'=>"color8",'9'=>"color9",'10'=>"color10",'11'=>"color11",'12'=>"color12",'13'=>"color13",'14'=>"color14",'15'=>"color15",'16'=>"color16",'17'=>"color17",'18'=>"color18",'19'=>"color19",'20'=>"color20",'21'=>"color21",'22'=>"color22",'23'=>"color23",'24'=>"color24",'25'=>"color25",'26'=>"color26",'27'=>"color27",'28'=>"color28",'29'=>"color29",'30'=>"color30",'31'=>"color31",'32'=>"color32",'33'=>"color33",'34'=>"color34",'35'=>"color35",'36'=>"color36",'37'=>"color37",'38'=>"color38",'39'=>"color39",'40'=>"color40",'41'=>"color41",'42'=>"color42",'43'=>"color43",'44'=>"color44",'45'=>"color45",'46'=>"color46",'47'=>"color47",'48'=>"color48",'49'=>"color49",'50'=>"color50",'51'=>"color51",'52'=>"color52",'53'=>"color53",'54'=>"color54",'55'=>"color55",'56'=>"color56",'57'=>"color57",'58'=>"color58",'59'=>"color59",'60'=>"color60",'61'=>"color61",'62'=>"color62",'63'=>"color63",'64'=>"color64",'65'=>"color65",'66'=>"color66",'67'=>"color67",'68'=>"color68",'69'=>"color69",'70'=>"color70",'71'=>"color71",'72'=>"color72",'73'=>"color73",'74'=>"color74",'75'=>"color75",'76'=>"color76",'77'=>"color77",'78'=>"color78",'79'=>"color79",'80'=>"color80",'81'=>"color81",'82'=>"color82",'83'=>"color83",'84'=>"color84",'85'=>"color85",'86'=>"color86",'87'=>"color87",'88'=>"color88",'89'=>"color89",'90'=>"color90",'91'=>"color91",'92'=>"color92",'93'=>"color93",'94'=>"color94",'95'=>"color95",'96'=>"color96",'97'=>"color97",'98'=>"color98",'99'=>"color99",'100'=>"color100",'101'=>"color101",'102'=>"color102",'103'=>"color103",'104'=>"color104",'105'=>"color105",'106'=>"color106",'107'=>"color107",'108'=>"color108",'109'=>"color109",'110'=>"color110",'111'=>"color111",'112'=>"color112",'113'=>"color113",'114'=>"color114",'115'=>"color115",'116'=>"color116",'117'=>"color117",'118'=>"color118",'119'=>"color119",'120'=>"color120",'121'=>"color121",'122'=>"color122",'123'=>"color123",'124'=>"color124",'125'=>"color125",'126'=>"color126",'127'=>"color127",'128'=>"color128",'129'=>"color129",'130'=>"color130",'131'=>"color131",'132'=>"color132",'133'=>"color133",'134'=>"color134",'135'=>"color135",'136'=>"color136",'137'=>"color137",'138'=>"color138",'139'=>"color139",'140'=>"color140",'141'=>"color141",'142'=>"color142",'143'=>"color143",'144'=>"color144",'145'=>"color145",'146'=>"color146",'147'=>"color147",'148'=>"color148",'149'=>"color149",'150'=>"color150",'151'=>"color151",'152'=>"color152",'153'=>"color153",'154'=>"color154",'155'=>"color155",'156'=>"color156",'157'=>"color157",'158'=>"color158",'159'=>"color159",'160'=>"color160",'161'=>"color161",'162'=>"color162",'163'=>"color163",'164'=>"color164",'165'=>"color165",'166'=>"color166",'167'=>"color167",'168'=>"color168",'169'=>"color169",'170'=>"color170",'171'=>"color171",'172'=>"color172",'173'=>"color173",'174'=>"color174",'175'=>"color175",'176'=>"color176",'177'=>"color177",'178'=>"color178",'179'=>"color179",'180'=>"color180",'181'=>"color181",'182'=>"color182",'183'=>"color183",'184'=>"color184",'185'=>"color185",'186'=>"color186",'187'=>"color187",'188'=>"color188",'189'=>"color189",'190'=>"color190",'191'=>"color191",'192'=>"color192",'193'=>"color193",'194'=>"color194",'195'=>"color195",'196'=>"color196",'197'=>"color197",'198'=>"color198",'199'=>"color199",'200'=>"color200",'201'=>"color201",'202'=>"color202",'203'=>"color203",'204'=>"color204",'205'=>"color205",'206'=>"color206",'207'=>"color207",'208'=>"color208",'209'=>"color209",'210'=>"color210",'211'=>"color211",'212'=>"color212",'213'=>"color213",'214'=>"color214",'215'=>"color215");

            for($x=0;$x<216;$x++){
                $query = "insert into colores values($x,'".$codigosdecolor[$x]."')";
                if(@mysql_query($query)){
                    $_SESSION['insertados'] = 'Datos insertados.';
                }else{
                    $_SESSION['insertados'] = 'Datos no insertados.';
                }
            }
        } else{
            $_SESSION['tablas'] = 'No se han podido crear las tablas.';
        }
    }
}
?>