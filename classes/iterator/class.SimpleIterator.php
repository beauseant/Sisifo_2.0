<?php


	/**
	* Esta clase se encarga de dar procedimientos genericos para recorrer la base de datos.
	* Para ello se ha recurrido al patron <b>iterator</b>. La clase SimpleIterator sera la
	* la clase padre de la cual heredaran las que se necesiten para hacer los recorridos. 
	* Recorridos de incidencias, de tipos de usuario, de mensajes...
	* Para mas informacion sobre el patron iterator:
	* {@link http://www.phppatterns.com/index.php/article/articleview/50/1/1/}
	* @package Iterator
	*/  
class SimpleIterator {

	/**
	* La funcion fetch se usa para recorrer la lista.
	* Los hijos podran implementarla de la forma que quieran, pero siempre respetando
	* la sintaxis.
	*/
    function fetch() {
        die ('SimpleIterator::fetch debe ser implementado');
    }

	/**
	* La funcion fetch se usa para devolver el tamaño de la lista.
	* Los hijos podran implementarla de la forma que quieran, pero siempre respetando
	* la sintaxis.
	*/    
    function size() {
        die ('SimpleIterator::size debe ser implementado');
    }

    
	/**
	* La funcion fetch se usa para saber si hemos llegado al final.
	* Los hijos podran implementarla de la forma que quieran, pero siempre respetando
	* la sintaxis.
	*/    
    function EOF () {
        die ('SimpleIterator::EOF debe ser implementado');
    }
}
?>