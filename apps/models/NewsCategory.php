<?php

namespace models;

use models\model\ORMModel;

/**
 * NewsCategory
 *
 * @author yuo <pors37@gmail.com>
 */
class NewsCategory extends ORMModel {
    
    public function __construct()
    {
        parent::__construct("models\\entity\\news\\Category");
    }
    
    public function getAllCategories($limit=NULL, $offset=NULL)
    {
        $dql = "SELECT Category FROM models\\entity\\news\\Category AS Category";
        $query = $this->_em->createQuery($dql);
        $query->setFirstResult($offset);
        $query->setMaxResults($limit);
        return $query->getResult();
    }
}
// End of file