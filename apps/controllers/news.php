<?php

/**
 * NewsController
 *
 * @author yuo1628 <s11977037@gms.nutc.edu.tw>
 */
class News extends MY_Controller
{
    /**
     * 至此Controller的連結
     */
    const PREFIX_URL = 'http://localhost:4413/funeat-web/index.php/news/';
    
    /**
     * 預設的分頁頁數
     */
    const DEFAULT_PAGE = 0;
    
    /**
     * 預測的分頁一頁顯示數量
     */
    const DEFAULT_PERPAGE = 7;
    
    private $newsModel;
    
    public function __construct()
    {
        parent::__construct('default');
        
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->newsModel = $this->getModel('News');
        $this->newsCategoryModel = $this->getModel('NewsCategory');
    }
    
    /**
     * 顯示新聞
     *
     * 預期接受GET參數perpage
     *
     * @access public
     */
    public function index($page=self::DEFAULT_PAGE)
    {
        // 設定分頁
        $paginationConfig = array();
        $totalRows = $this->newsModel->getCount();
        $perpage = filter_input(INPUT_GET, 'perpage', FILTER_VALIDATE_INT);
        $perpage = (int) $perpage;
        $perpage = $perpage > 0 ? $perpage : self::DEFAULT_PERPAGE;

        // 驗證分頁範圍
        $page = $this->_sanitizePageRange($page, $perpage, $totalRows);
        
        $paginationConfig['suffix'] = '?perpage=' . $perpage;
        $paginationConfig['per_page'] = $perpage;
        $paginationConfig['base_url'] = self::PREFIX_URL;
        $paginationConfig['total_rows'] = $totalRows;
        $paginationConfig['cur_page'] = $page;
        $this->pagination->initialize($paginationConfig);
        
        // 載入資料
        $this->setData('news', $this->newsModel->getAllNews($perpage, $page));
        $this->setData('addUrl', './index.php/news/addnews');
        $this->setData('postEditUrl', './index.php/news/editnews');
        $this->setData('postDeleteUrl', './index.php/news/deletenews');
        $this->setData('pagination', $this->pagination);
        $this->setData('currentUrl', $this->_getCurrentViewdUrl());
        
        $this->view('news/listnews.php');
    }
    
    /**
     * 新增新聞
     *
     * @access public
     */
    public function addNews()
    {
        // 初始化
        $news = $this->newsModel->getInstance();
        $errors = array();
        
        // 處理POST新聞資料
        $postData = filter_input_array(INPUT_POST, array('id' => FILTER_SANITIZE_STRING,
                                                         'title' => FILTER_SANITIZE_STRING,
                                                         'content' => FILTER_SANITIZE_STRING,
                                                         'category_id' => FILTER_SANITIZE_NUMBER_INT));
        if ($postData and !in_array(NULL, $postData, True)) {
            $news->title = $postData['title'];
            $news->content = $postData['content'];
            $news->createAt = new DateTime();
            $news->createIP = $this->input->ip_address();
            $news->category = $this->newsCategoryModel->getItem($postData['category_id']);
            // TODO Validate
            if ($this->newsModel->save($news)) {
                // 新增成功
                // 重導向
                redirect(self::PREFIX_URL, 'Location', 302);
            } else {
                // 新增失敗
                $errors[] = '新增失敗';
            }
        }
        
        // 設定頁面資料
        $this->setData('news', $news);
        $this->setData('categories', $this->newsCategoryModel->getAllCategories());
        $this->setData('postUrl', self::PREFIX_URL . 'addnews');
        $this->setData('redirectUrl', self::PREFIX_URL);
        $this->setData('title', '新增新聞');
        $this->setData('errors', $errors);
        
        $this->view('news/editnews.php');
    }
    
    /**
     * 編輯指定的新聞
     *
     * 此方法會從POST資料中取得name為id的資料當作新聞編號
     *
     * @access public
     */
    public function editNews()
    {
        // 接收POST傳來的新聞資料庫編號
        $newsId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$newsId) {
            return;
        }
        $news = $this->newsModel->getItem($newsId);
        if (!$news) {
            return;
        }
        
        $redirectUrl = $this->_getRedirectUrlFromPost();
        
        // 初始化變數
        $errors = array();
        $infos = array();
        
        // 執行編輯操作
        $postData = filter_input_array(INPUT_POST, array('title' => FILTER_SANITIZE_STRING,
                                                         'content' => FILTER_SANITIZE_STRING,
                                                         'category_id' => FILTER_SANITIZE_NUMBER_INT));
        if ($postData and !in_array(NULL, $postData, True) and !in_array(False, $postData, True)) {
            $news->title = $postData['title'];
            $news->content = $postData['content'];
            try {
                $newsCategory = $this->newsCategoryModel->getItem($postData['category_id']);
                $news->category = $newsCategory;
                $this->newsModel->save($news);
                redirect($redirectUrl, 'Location', 302);
            } catch (PDOException $e) {
                $errors[] = '編輯新聞時發生錯誤，請確認資料的正確性';
            }
        }
        
        $this->setData('title', '編輯新聞');
        $this->setData('news', $news);
        $this->setData('postUrl', self::PREFIX_URL . 'editnews');
        $this->setData('redirectUrl', $redirectUrl);
        $this->setData('categories', $this->newsCategoryModel->getAllCategories());
        $this->setData('errors', $errors);
        $this->setData('infos', $infos);
        
        $this->view('news/editnews.php');
    }
    
    /**
     * 刪除新聞
     *
     * 此方法會從POST資料中取得name為id的資料當作新聞編號
     *
     * @access public
     */
    public function deleteNews()
    {
        // 接收POST傳來的新聞資料庫編號
        $newsId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$newsId) {
            return;
        }
        $news = $this->newsModel->getItem($newsId);
        if (!$news) {
            return;
        }
        
        $redirectUrl = $this->_getRedirectUrlFromPost();
        
        $this->newsModel->remove($news);
        redirect($redirectUrl, 'Location', 302);
    }
    
    /**
     * 新增分類
     *
     * @access public
     */
    public function addCategory()
    {
        // 初始化資料
        $category = new models\entity\news\Category();
        $errors = array();
        
        // 處理POST過來的分類資料
        $postData = filter_input_array(INPUT_POST, array('id' => FILTER_SANITIZE_STRING,
                                                        'name' => FILTER_SANITIZE_STRING));
        if ($postData and !in_array(NULL, $postData, True) and !in_array(False, $postData, True)) {
            // TODO Validate
            $category->setName($postData['name']);
            try {
                $this->doctrine->em->persist($category);
                $this->doctrine->em->flush();
                redirect(self::PREFIX_URL . 'managecategories', 'Location', 302);
            } catch (PDOException $e) {
                // 新增失敗
                $errors[] = '新增失敗';
            }
        }
        
        // 設定頁面資料
        $this->setData('category', $category);
        $this->setData('postUrl', self::PREFIX_URL . 'addcategory');
        $this->setData('title', '新增分類');
        $this->setData('errors', $errors);
        
        $this->view('news/editcategory.php');
    }
    
    /**
     * 編輯分類
     *
     * @access public
     */
    public function editCategory()
    {
        // 初始化
        $errors = array();
        
        // 接收分類的id資料
        $categoryId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$categoryId) {
            // TODO redirect or show 404
            return;
        }
        $category = $this->newsCategoryModel->getItem($categoryId);
        if (!$category) {
            // TODO redirect or show 404
            return;
        }
        // 執行更新動作
        $postData = filter_input_array(INPUT_POST, array('name' => FILTER_SANITIZE_STRING));
        if ($postData and !in_array(NULL, $postData, True) and !in_array(False, $postData, True)) {
            $category->setName($postData['name']);
            // TODO Validate
            if ($this->newsCategoryModel->save($category)) {
                redirect(self::PREFIX_URL . 'managecategories', 'Location', 302);
            } else {
                $errors[] = '分類更新失敗';
            }
        }
        
        $this->setData('title', '編輯分類');
        $this->setData('category', $category);
        $this->setData('postUrl', self::PREFIX_URL . 'editcategory');
        $this->setData('errors', $errors);
        
        $this->view('news/editcategory.php');
    }
    
    /**
     * 刪除分類
     *
     * @access public
     */
    public function deleteCategory()
    {
        // 接收POST傳來的分類編號
        $categoryId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$categoryId) {
            return;
        }
        $category = $this->newsCategoryModel->getItem($categoryId);
        if (!$category) {
            return;
        }
        
        // 執行刪除動作
        $this->newsCategoryModel->remove($category);
        redirect(self::PREFIX_URL . 'managecategories', 'Location', 302);
    }
    
    /**
     * 管理分類
     *
     * @access public
     */
    public function manageCategories($page=self::DEFAULT_PAGE)
    {
        // 設定分頁資料
        $perpage = filter_input(INPUT_GET, 'perpage', FILTER_VALIDATE_INT);
        $perpage = (int) $perpage;
        $perpage = $perpage > 0 ? $perpage : self::DEFAULT_PERPAGE;
        $totalRows = $this->newsCategoryModel->getCount();
        
        $page = $this->_sanitizePageRange($page, $perpage, $totalRows);
        
        $paginationConfig = array();
        $paginationConfig['base_url'] = self::PREFIX_URL . 'managecategories';
        $paginationConfig['total_rows'] = $totalRows;
        $paginationConfig['per_page'] = $perpage;
        $paginationConfig['suffix'] = '?perpage=' . $perpage;
        $this->pagination->initialize($paginationConfig);
        
        $this->setData('title', '管理分類');
        $this->setData('categories', $this->newsCategoryModel->getAllCategories($perpage, $page));
        $this->setData('addUrl', self::PREFIX_URL . 'addcategory');
        $this->setData('pagination', $this->pagination);
        $this->setData('postEditUrl', self::PREFIX_URL . 'editcategory');
        $this->setData('postDeleteUrl', self::PREFIX_URL . 'deletecategory');
        
        $this->view('news/listcategories.php');
    }
    
    
    public function _getRedirectUrlFromPost()
    {
        // 設定導向資料
        $redirectUrlSources = filter_input_array(INPUT_POST, array('postfromurl' => FILTER_VALIDATE_URL,
                                                                   'redirecturl' => FILTER_VALIDATE_URL));
        $redirectUrl = NULL;
        foreach ($redirectUrlSources as $redirectUrlSource) {
            if ($redirectUrlSource) {
                $redirectUrl = $redirectUrlSource;
                break;
            }
        }
        $redirectUrl = $redirectUrl ? $redirectUrl : self::PREFIX_URL;
        return $redirectUrl;
    }
    
    /**
     * 取得目前檢視頁面的URL
     *
     * @access private
     * @return string
     */
    private function _getCurrentViewdUrl()
    {
        return 'http://' . rtrim($_SERVER['SERVER_NAME'], '/') . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
    }
    
    /**
     * 正常化分頁範圍
     *
     * @access private
     * @param int $page 分頁頁數（筆數）
     * @param int $perpage
     * @param int $totalPages
     * @return int
     */
    private function _sanitizePageRange($page, $perpage, $totalRows)
    {
        if ($page >= $totalRows) {
            
            //$page = $totalRows - $perpage;
            $page = floor($totalRows / $perpage) * $perpage;
            print $page;
        }
        if ($page < 0) {
            $page = 0;
        }
        return $page;
    }
}
// End of file