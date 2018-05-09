<?php

namespace App\Http\Controllers;

use App\Models\Json;
use Illuminate\Http\Request;

class SubastaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getJson()
    {
        $url = "https://eu.api.battle.net/wow/auction/data/shen'dralar?locale=es_ES&apikey=8hw8e9kun6sf8kfh2qvjzw22b9wzzjek";
        $contenido = json_decode(file_get_contents($url));
        $existentJson = Json::Fecha_numerica($contenido->files[0]->lastModified)->first();
        if(is_null($existentJson)){
            $filejson = new Json;
            $filejson->url = $contenido->files[0]->url;
            $filejson->fecha_numerica = $contenido->files[0]->lastModified;
            $filejson->fecha = date("Y-m-d H:i:s",$contenido->files[0]->lastModified);

            $filejson->save();
        }
        return $this->getAuctions($contenido->files[0]->url);
    }
    
    public function getRealms($subastas){
        foreach ($subastas as $key => $valueSubasta) {
            $existentRealm = Realm::Nombre($valueSubasta['ownerRealm']);
            if(is_null($existentRealm)){
                $newRealm = new Realm;
                $newRealm->Nombre = $valueSubasta['ownerRealm'];
                $newRealm->save();
            }
        }
    }
    
    public function getOwners($subastas){
        foreach ($subastas as $key => $valueSubasta) {
            $existentOwner = Owner::Nombre($valueSubasta['ownerRealm']);
            if(is_null($existentOwner)){
                $newOwner = new Owner;
                $newOwner->Nombre = $valueSubasta['ownerRealm'];
                $newOwner->save();
            }
        }
    }
    
    public function index()
    {
        $json = $this->getJson();
        $owners = $this->getRealms($json);
        
        die('final');
        $url = "https://eu.api.battle.net/wow/auction/data/shen'dralar?locale=es_ES&apikey=8hw8e9kun6sf8kfh2qvjzw22b9wzzjek";
        $contenido = json_decode(file_get_contents($url));

        $existentJson = Json::Fecha_numerica($contenido->files[0]->lastModified)->first();
        if(is_null($existentJson)){
            /*$filejson = new Json;
            $filejson->url = $contenido->files[0]->url;
            $filejson->datenum = $contenido->files[0]->lastModified;
            $filejson->date = date("Y-m-d H:i:s",$contenido->files[0]->lastModified);

            $filejson->save();*/

            $subastas = $this->getAuctions($contenido->files[0]->url);

            foreach ($subastas as $key => $valueSubasta) {
                if(!isset($item[$valueSubasta['item']])){
                    $item_valores[$valueSubasta['item']] = 0;
                    $item_precios[$valueSubasta['item']] = 0;
                }
                $item_valores[$valueSubasta['item']] += $valueSubasta['buyout'];
                $item_precios[$valueSubasta['item']] += $valueSubasta['quantity'];
            }
            foreach ($item_valores as $keyv => $valuev) {
                $precio_medio[$keyv] = $item_valores[$keyv] / $item_precios[$keyv];
            }

            foreach ($subastas as $key => $nValueSubasta) {
                if($precio_medio[$nValueSubasta['item']] < ($nValueSubasta['buyout'] / $nValueSubasta['quantity'])*(0.75) ){
                    $subasta_valida[] = $nValueSubasta;
                }
                elseif($precio_medio[$nValueSubasta['item']] > ($nValueSubasta['buyout'] / $nValueSubasta['quantity'])*(0.75) ){
                    //Sobreprecio,ignorar
                }
                else{
                    if(!isset($item[$nValueSubasta['item']])){
                        $item_valores_real[$nValueSubasta['item']] = 0;
                        $item_precios_real[$nValueSubasta['item']] = 0;
                    }   
                    $item_valores_real[$nValueSubasta['item']] += $nValueSubasta['buyout'];
                    $item_precios_real[$nValueSubasta['item']] += $nValueSubasta['quantity'];
                }
            }
            foreach ($item_valores_real as $keyR => $valueR) {
                $precio_medio_real[$keyR] = $item_valores_real[$keyR] / $item_precios_real[$keyR];
            }
        }
        else{
            return 'Insertado previamente';
        }
        var_dump($precio_medio_real);
    }

    public function json_validate($string)
    {
        // decode the JSON data
        $result = json_decode($string);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            exit($error);
        }

        // everything is OK
        return $result;
    }

    /**
     * [Funcion para obtener el json con subastas y devolver un array con las mismas]
     * @param  [string] $url [URL con las subastas]
     * @return [array]      [Array con todas las subastas]
     */
    public function getAuctions($url){
        $contenido_url = '';
            
        $handle = fopen($url, "r");
        if ($handle) {
            while (fgets($handle) !== false || !feof($handle)):
                $line = fgets($handle);
                if(strstr($line, '"auc"')){
                    $line = str_replace("\r\n",'', $line);
                    $line = str_replace("\t",'', $line);
                    $line = trim($line);
                    $line = trim($line,',');
                    $elementos_a_tratar = explode(',', $line);
                    foreach($elementos_a_tratar as $key=> $pareja_campo_valor){

                        $pareja_campo_valor = trim(str_replace('"','', $pareja_campo_valor));
                        $pareja_campo_valor = str_replace('{','', $pareja_campo_valor);
                        $pareja_campo_valor = str_replace('}','', $pareja_campo_valor);
                        $pareja_campo_valor = str_replace('[','', $pareja_campo_valor);
                        $pareja_campo_valor = str_replace(']','', $pareja_campo_valor);
                        $valores = explode(':', $pareja_campo_valor);
                        if(isset($valores[1])){
                            $item_subasta[$valores[0]] = $valores[1];
                        }
                        else{
                           
                        }
                    }

                    $subasta[] = $item_subasta;
                    unset($item_subasta);
                }
                else{
                     
                }
                //$contenido_url .=$line;
            endwhile;
            fclose($handle);
        } else {
            dd('Error al abrir el archivo');
        }

        return $subasta;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
