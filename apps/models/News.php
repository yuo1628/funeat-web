<?php

namespace models;

use models\model\ORMModel as ORMModel;

/**
 * News Model
 *
 * @category models
 * @author yuo1628 <pors37@gmail.com>
 */
class News extends ORMModel {

    public function __construct()
    {
        parent::__construct('models\\Entity\\news\\News');
    }
    
    /**
     * 取得所有新聞
     *
     * @access public
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllNews($limit=NULL, $offset=NULL)
    {
        $query = $this->_em->createQuery(<<<SQL
            SELECT n FROM models\\Entity\\news\\News AS n
SQL
        );
        $query->setMaxResults(!is_null($limit) ? $limit : PHP_INT_MAX);
        $query->setFirstResult(!is_null($offset) ? $offset : 0);
        return $query->getResult();
    }
    
    /**
     * 取得指定的新聞
     *
     * @access public
     * @param int $id
     * @return array|NULL
     */
    public function getNewsById($id)
    {
        return $this->_repository->find($id);
    }
}

// End of file