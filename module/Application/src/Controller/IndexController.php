<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Post;

class IndexController extends AbstractActionController
{
    private $entityManager;

    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $posts = $this->entityManager->getRepository(Post::class)
                        ->findBy(['status'=>Post::STATUS_PUBLISHED], 
                                ['dateCreated'=>'DESC']);
        
        return new ViewModel([
            'posts' => $posts
        ]);
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}
