<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

require_once 'lib/Portabilis/Controller/ApiCoreController.php';
require_once 'App/Model/IedFinder.php';

/**
 * AreaConhecimento class.
 *
 * @author      Gabriel Matos de Souza <gabriel@portabilis.com.br>
 * @category    i-Educar
 * @license     @@license@@
 * @package     Avaliacao
 * @subpackage  Modules
 * @since       Classe disponível desde a versão ??
 * @version     @@package_version@@
 */
class AreaConhecimentoController extends ApiCoreController{

  protected function getAreasConhecimento() {

     $instituicaoId = $this->getRequest()->instituicao_id;
    
     $sql    = 'SELECT ac.id as id, ac.nome as nome
    			        FROM modules.area_conhecimento ac
                 WHERE ac.instituicao_id = $1
                 ORDER BY to_ascii(lower(ac.nome)) ASC';

    $areasConhecimento = array();
    $paramsSql = array('params' => $instituicaoId );
    $areasConhecimento = $this->fetchPreparedQuery($sql, $paramsSql);
    $options = array();

    foreach ($areasConhecimento as $areaConhecimento){
      $options['__' . $areaConhecimento['id']] = $this->toUtf8($areaConhecimento['nome']);
    }
    return array('options' => $options);

  }

  public function Gerar() {
    if ($this->isRequestFor('get', 'area_conhecimento'))
      $this->appendResponse($this->getAreasConhecimento());
    else
      $this->notImplementedOperationError();
  }
}