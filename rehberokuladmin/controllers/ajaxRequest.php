<?php
class AjaxRequest extends Controller {
    
    public $db;
    public $files = [];
    
    public function __construct($action, $request) {
        parent::__construct($action, $request);
        $this->db = new DBOperation();
    }
    protected function index() {
        echo FileUploader::uploadSingleFileToServer('file');
    }
    
    protected function delete() {
        $src = $_POST['src'];
        echo "<script>alert('".$_POST['token']."');</script>";
        $file_name =  str_replace(ROOT_URL, '', $src); // C:\\ gibi uzantı kısımlarını siliyoruz
        if(unlink($file_name))
        {
            echo 'File Delete Successfully';
        }
    }
    
    private function getAuthor($authorId) {
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT * FROM author WHERE id = ".$authorId);
            $this->db->statement->execute();
            $author = $this->db->statement->fetch();
            return $author['name'].' '.$author['surname'];
    }
    
    protected function news() {
          ## Read value

            $draw = $_POST['draw'];
            $start = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
            
            $searchArray = array();

            ## Search 
            $searchQuery = " ";
            if($searchValue != ''){
               $searchQuery = " AND (baslik LIKE :baslik or 
                    aciklama LIKE :aciklama) ";
               $searchArray = array( 
                    'baslik'=>"%$searchValue%", 
                    'aciklama'=>"%$searchValue%"
               );
            }
            
            ## Total number of records without filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM haber WHERE news_checked = 1");
            $this->db->statement->execute();
            $records = $this->db->statement->fetch();        
            $totalRecords = $records['allcount'];

            
            ## Total number of records with filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM haber WHERE news_checked = 1 ".$searchQuery);
            $this->db->statement->execute($searchArray);
            $records = $this->db->statement->fetch();
            $totalRecordwithFilter = $records['allcount'];
            
            ## Fetch records
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT * FROM haber WHERE news_checked = 1 ".$searchQuery." ORDER BY yayin_tarihi DESC, id DESC LIMIT :limit,:offset");
            // Bind values
            foreach($searchArray as $key=>$search){
               $this->db->statement->bindValue(':'.$key, $search,PDO::PARAM_STR);
            }
            
           

            $this->db->statement->bindValue(':limit', (int)$start, PDO::PARAM_INT);
            $this->db->statement->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $this->db->statement->execute();
            $empRecords = $this->db->statement->fetchAll();

            $data = array();
            $nm = new NewsModel();
            $nc = new News();
            $counter = 1;
           foreach($empRecords as $row){
                $onizleme = $row['news_checked'] == 1 ? '<a href="'.str_replace('panel/', '', ROOT_URL).'haber/'.$row['seflink'].'" target="_blank" title="Önizleme"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" style="display:none;"> <i class="fa fa-search"></i></button></a>'
                                    : '<a href="'.str_replace('panel/', '', ROOT_URL).'haber/'.$row['seflink'].'" target="_blank" title="Önizleme"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success"> <i class="fa fa-search"></i></button></a>';
                $duzenleme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? '<a href="news/viewEdit/'.$row['seflink'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" style="display:none;"> <i class="fa fa-edit"></i></button></a>'
                                    : '<a href="news/viewEdit/'.$row['seflink'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info"> <i class="fa fa-edit"></i></button></a>';
                $detay = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? '<a href="news/detail/'.$row['seflink'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" style="display:none;"> <i class="fa fa-search"></i></button></a>'
                                    : '<a href="news/detail/'.$row['seflink'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning"> <i class="fa fa-search"></i></button></a>';
                $silme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? '<a href="news/viewEdit/'.$row['seflink'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" style="display:none;"> <i class="fa fa-trash"></i></button></a>'
                                    : '<a href="news/viewDelete/'.$row['seflink'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button></a>';
            
               $data[] = array(
                   'ind' => $counter + $start,
                  "baslik"=>$row['baslik'],
                  "aciklama"=>$row['aciklama'],
                  "yayin_tarihi"=>date('d/m/Y',strtotime($row['yayin_tarihi'])),
                  "author_id"=>$this->getAuthor($row['author_id']),
                  "sira"=>$row['sira'] == '9' ? 'Yok' : $row['sira'],
                  "islemler" => $onizleme.$duzenleme.$detay.$silme
                 );
               $counter++;
            }                           
            

            ## Response
            $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
            );
            
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    
    protected function posts() {
          ## Read value

            $draw = $_POST['draw'];
            $start = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
            
            $searchArray = array();

            ## Search 
            $searchQuery = " ";
            if($searchValue != ''){
               $searchQuery = " AND (baslik LIKE :baslik or 
                    aciklama LIKE :aciklama) ";
               $searchArray = array( 
                    'baslik'=>"%$searchValue%", 
                    'aciklama'=>"%$searchValue%"
               );
            }
            
            ## Total number of records without filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM post WHERE news_checked = 1");
            $this->db->statement->execute();
            $records = $this->db->statement->fetch();        
            $totalRecords = $records['allcount'];

            
            ## Total number of records with filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM post WHERE news_checked = 1 ".$searchQuery);
            $this->db->statement->execute($searchArray);
            $records = $this->db->statement->fetch();
            $totalRecordwithFilter = $records['allcount'];
            
            ## Fetch records
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT * FROM post WHERE news_checked = 1 ".$searchQuery." ORDER BY yayin_tarihi DESC, id DESC LIMIT :limit,:offset");
            // Bind values
            foreach($searchArray as $key=>$search){
               $this->db->statement->bindValue(':'.$key, $search,PDO::PARAM_STR);
            }
            
           

            $this->db->statement->bindValue(':limit', (int)$start, PDO::PARAM_INT);
            $this->db->statement->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $this->db->statement->execute();
            $empRecords = $this->db->statement->fetchAll();

            $data = array();
            $nm = new PostModel();
            $nc = new Post();
            $counter = 1;
           foreach($empRecords as $row){
                $duzenleme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? '<a href="post/viewEdit/'.$row['seflink'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" style="display:none;"> <i class="fa fa-edit"></i></button></a>'
                                    : '<a href="post/viewEdit/'.$row['seflink'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info"> <i class="fa fa-edit"></i></button></a>';
                $detay = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? '<a href="post/detail/'.$row['seflink'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" style="display:none;"> <i class="fa fa-search"></i></button></a>'
                                    : '<a href="post/detail/'.$row['seflink'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning"> <i class="fa fa-search"></i></button></a>';
                $silme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? '<a href="post/viewEdit/'.$row['seflink'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" style="display:none;"> <i class="fa fa-trash"></i></button></a>'
                                    : '<a href="post/viewDelete/'.$row['seflink'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button></a>';
            
               $data[] = array(
                   'ind' => $counter + $start,
                  "baslik"=>$row['baslik'],
                  "aciklama"=>$row['aciklama'],
                  "yayin_tarihi"=>date('d/m/Y',strtotime($row['yayin_tarihi'])),
                  "author_id"=>$this->getAuthor($row['author_id']),
                  "sira"=>$row['sira'] == '9' ? 'Yok' : $row['sira'],
                  "islemler" => $duzenleme.$detay.$silme
                 );
               $counter++;
            }                           
            

            ## Response
            $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
            );
            
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    
    
    protected function authors() {
          ## Read value

            $draw = $_POST['draw'];
            $start = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
            
            $searchArray = array();

            ## Search 
            $searchQuery = " ";
            if($searchValue != ''){
               $searchQuery = " AND (name LIKE :name or 
                    surname LIKE :surname OR 
                    city LIKE :city) ";
               $searchArray = array( 
                    'name'=>"%$searchValue%", 
                    'surname'=>"%$searchValue%",
                    'city'=>"%$searchValue%"
               );
            }
            
            ## Total number of records without filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM author ");
            $this->db->statement->execute();
            $records = $this->db->statement->fetch();        
            $totalRecords = $records['allcount'];

            
            ## Total number of records with filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM author WHERE 1 ".$searchQuery);
            $this->db->statement->execute($searchArray);
            $records = $this->db->statement->fetch();
            $totalRecordwithFilter = $records['allcount'];
            
            ## Fetch records
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT * FROM author WHERE 1 ".$searchQuery." ORDER BY name ASC, id DESC LIMIT :limit,:offset");
            // Bind values
            foreach($searchArray as $key=>$search){
               $this->db->statement->bindValue(':'.$key, $search,PDO::PARAM_STR);
            }
            
           

            $this->db->statement->bindValue(':limit', (int)$start, PDO::PARAM_INT);
            $this->db->statement->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $this->db->statement->execute();
            $empRecords = $this->db->statement->fetchAll();

            $data = array();
            $nm = new AuthorModel();
            $nc = new Author();
            $counter = 1;
           foreach($empRecords as $row){
               
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT (select count(*) from haber where author_id =".$row['id'].") + (select count(*) from post where author_id =".$row['id'].") as total");
            $this->db->statement->execute();
            $yazilar = $this->db->statement->fetch();
            $totalYazilar = $yazilar['total'];
            
               
                $duzenleme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? '<a href="author/viewEdit/'.$row['link'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" style="display:none;"> <i class="fa fa-edit"></i></button></a>'
                                    : '<a href="author/viewEdit/'.$row['link'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info"> <i class="fa fa-edit"></i></button></a>';
                $detay = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? '<a href="author/detail/'.$row['link'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" style="display:none;"> <i class="fa fa-search"></i></button></a>'
                                    : '<a href="author/detail/'.$row['link'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning"> <i class="fa fa-search"></i></button></a>';
                $silme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? '<a href="author/viewEdit/'.$row['link'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" style="display:none;"> <i class="fa fa-trash"></i></button></a>'
                                    : '<a href="author/viewDelete/'.$row['link'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button></a>';
            
               $foto = $row['image_src'] == '' ? '../img/profil/writer.jpg' : $row['image_src'];
               $data[] = array(
                  'ind' => $counter + $start,
                  "name"=>$row['name'].' '.$row['surname'],
                  "city"=> $row['city'],
                   'fotograf'=>"<img src=".$foto." style='width:100px; height: 100px' />",
                  "count_author"=>$totalYazilar,
                  "islemler" => $duzenleme.$detay.$silme
                 );
               $counter++;
            }                           
            

            ## Response
            $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
            );
            
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    
    protected function gallery() {
          ## Read value

            $draw = $_POST['draw'];
            $start = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
            
            $searchArray = array();

            ## Search 
            $searchQuery = " ";
            if($searchValue != ''){
               $searchQuery = " AND (text LIKE :text) ";
               $searchArray = array( 
                    'text'=>"%$searchValue%"
               );
            }
            
            ## Total number of records without filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM gallery WHERE is_listed = 1");
            $this->db->statement->execute();
            $records = $this->db->statement->fetch();        
            $totalRecords = $records['allcount'];

            
            ## Total number of records with filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM gallery WHERE is_listed = 1 ".$searchQuery);
            $this->db->statement->execute($searchArray);
            $records = $this->db->statement->fetch();
            $totalRecordwithFilter = $records['allcount'];
            
            ## Fetch records
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT * FROM gallery WHERE is_listed = 1 ".$searchQuery." ORDER BY text ASC, id DESC LIMIT :limit,:offset");
            // Bind values
            foreach($searchArray as $key=>$search){
               $this->db->statement->bindValue(':'.$key, $search,PDO::PARAM_STR);
            }
            
           

            $this->db->statement->bindValue(':limit', (int)$start, PDO::PARAM_INT);
            $this->db->statement->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $this->db->statement->execute();
            $empRecords = $this->db->statement->fetchAll();

            $data = array();
            $nm = new GalleryModel();
            $nc = new Gallery();
            $counter = 1;
           foreach($empRecords as $row){
                $cikart = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $row['isdir'] == 1 || $row['parent_id'] <= 5 ? '<a href="gallery/viewDiscard/'.$row['link'].'" title="Galeriden Çıkart"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" style="display:none;"> <i class="fa fa-minus"></i></button></a>'
                                    : '<a href="gallery/viewDiscard/'.$row['link'].'" title="Galeriden Çıkart"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger"> <i class="fa fa-minus"></i></button></a>';
                $duzenleme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? '<a href="gallery/viewEdit/'.$row['link'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" style="display:none;"> <i class="fa fa-edit"></i></button></a>'
                                    : '<a href="gallery/viewEdit/'.$row['link'].'" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info"> <i class="fa fa-edit"></i></button></a>';
                $detay = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? '<a href="gallery/detail/'.$row['link'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" style="display:none;"> <i class="fa fa-search"></i></button></a>'
                                    : '<a href="gallery/detail/'.$row['link'].'" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning"> <i class="fa fa-search"></i></button></a>';
                $silme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? '<a href="gallery/viewEdit/'.$row['link'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" style="display:none;"> <i class="fa fa-trash"></i></button></a>'
                                    : '<a href="gallery/viewDelete/'.$row['link'].'" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button></a>';
            
               $data[] = array(
                  'ind' => $counter + $start,
                  "text"=>$row['text'],
                   'href'=>"<img src=".$row['href']." style='width:100px; height: 100px' />",
                  "parent_folder"=>$nm->getDirectoryName($nm->getDirectoryName($row['parent_id'])['parent_id'])['name'].' / '.$nm->getDirectoryName($row['parent_id'])['name'],
                   'is_dir'=>$nm->isDir($row['isdir']),
                  "islemler" => $cikart.$duzenleme.$detay.$silme
                 );
               $counter++;
            }                           
            

            ## Response
            $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
            );
            
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    
    protected function agenda() {
          ## Read value

            $draw = $_POST['draw'];
            $start = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
            
            $searchArray = array();

            ## Search 
            $searchQuery = " ";
            if($searchValue != ''){
               $searchQuery = " AND (baslik LIKE :baslik or 
                    aciklama LIKE :aciklama) ";
               $searchArray = array( 
                    'baslik'=>"%$searchValue%", 
                    'aciklama'=>"%$searchValue%"
               );
            }
            
            ## Total number of records without filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM haber WHERE news_checked = 1 AND agenda = 0");
            $this->db->statement->execute();
            $records = $this->db->statement->fetch();        
            $totalRecords = $records['allcount'];

            
            ## Total number of records with filtering
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT COUNT(*) AS allcount FROM haber WHERE news_checked = 1 AND agenda = 0 ".$searchQuery);
            $this->db->statement->execute($searchArray);
            $records = $this->db->statement->fetch();
            $totalRecordwithFilter = $records['allcount'];
            
            ## Fetch records
            $this->db->statement = $this->db->databaseHandler->prepare("SELECT * FROM haber WHERE news_checked = 1 AND agenda = 0 ".$searchQuery." ORDER BY yayin_tarihi DESC, id DESC LIMIT :limit,:offset");
            // Bind values
            foreach($searchArray as $key=>$search){
               $this->db->statement->bindValue(':'.$key, $search,PDO::PARAM_STR);
            }
            
           

            $this->db->statement->bindValue(':limit', (int)$start, PDO::PARAM_INT);
            $this->db->statement->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $this->db->statement->execute();
            $empRecords = $this->db->statement->fetchAll();

            $data = array();
            $nm = new NewsModel();
            $nc = new News();
            $counter = 1;
           foreach($empRecords as $row){
               
                $duzenleme = $nm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? '<a href="news/viewAddAgenda/'.$row['seflink'].'" title="Haftanın Gündemine Ekle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" style="display:none;"> <i class="fa fa-plus"></i></button></a>'
                                    : '<a href="news/viewAddAgenda/'.$row['seflink'].'" title="Haftanın Gündemine Ekle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success"> <i class="fa fa-plus"></i></button></a>';
            
               $data[] = array(
                   'ind' => $counter + $start,
                  "baslik"=>$row['baslik'],
                  "aciklama"=>$row['aciklama'],
                  "yayin_tarihi"=>date('d/m/Y',strtotime($row['yayin_tarihi'])),
                  "author_id"=>$this->getAuthor($row['author_id']),
                  "sira"=>$row['sira'] == '9' ? 'Yok' : $row['sira'],
                  "islemler" => $duzenleme.$detay.$silme
                 );
               $counter++;
            }                           
            

            ## Response
            $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
            );
            
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    protected function resp() {
        $this->db->findAll('gallery');
        $data = $this->db->resultSet();
        $itemsByReference = array();
 
        // Build array of item references:
        foreach($data as $key => &$item) {
           $itemsByReference[$item['id']] = &$item;
           $item['a_attr']->href = &$item['href'];
           // Children array:
           $itemsByReference[$item['id']]['children'] = array();
           // Empty data class (so that json_encode adds "data: {}" ) 
           $itemsByReference[$item['id']]['data'] = new stdClass();
        }

        // Set items as children of the relevant parent item.
        foreach($data as $key => &$item)
           if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
              $itemsByReference [$item['parent_id']]['children'][] = &$item;
              $item['a_attr']->href = &$item['href'];

        // Remove items that were added to parents elsewhere:
        foreach($data as $key => &$item) {
           if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
              unset($data[$key]);
        }
   
        // Encode:
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function delete_notification() {

        if (isset($_POST['notification']) && $_POST['notification'] > 0){
            $this->db->statement = $this->db->databaseHandler->prepare("update all_user_notifications set is_active = 0 where id =".$_POST['notification']);
            $this->db->statement->execute();
        }
    }

    public function mark_as_read() {

        if (isset($_POST['notification']) && $_POST['notification'] > 0){
            $this->db->statement = $this->db->databaseHandler->prepare("update all_user_notifications set as_read = 1 where id =".$_POST['notification']);
            $this->db->statement->execute();
        }
    }


    public function mark_as_unread() {

        if (isset($_POST['notification']) && $_POST['notification'] > 0){
            $this->db->statement = $this->db->databaseHandler->prepare("update all_user_notifications set as_read = 0 where id =".$_POST['notification']);
            $this->db->statement->execute();
        }
    }


    public function add_to_cart() {

        if (isset($_POST['selected_school']) && $_POST['selected_school'] > 0){
            $this->db->statement = $this->db->databaseHandler->prepare("select * from school  where id =".$_POST['selected_school']);
            $this->db->statement->execute();
            $school = $this->db->statement->fetch();

            $this->db->statement = $this->db->databaseHandler
                ->prepare("INSERT INTO cart (school_id, user_id, price, type)
            VALUES (".$school['id'].", ".$_SESSION['user_data']['user_id'].", ".$_POST['fiyat'].", ".$school['type'].")");
            $this->db->statement->execute();
        }
    }

    public function remove_from_cart() {

        if (isset($_POST['selected_cart_item']) && $_POST['selected_cart_item'] > 0){
            $this->db->statement = $this->db->databaseHandler->prepare("delete from cart where id =".$_POST['selected_cart_item']);
            $this->db->statement->execute();
        }
    }

    private function generateRandomString($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function complete_payment() {
        if (isset($_POST['user_id']) && $_POST['user_id'] > 0){

            $this->db->statement = $this->db->databaseHandler->prepare("select * from cart where user_id =".$_POST['user_id']);
            $this->db->statement->execute();
            $cart_items = $this->db->statement->fetchAll();

            $reference_no = $this->generateRandomString();

            foreach($cart_items as $cart_item) {
                $this->db->statement = $this->db->databaseHandler
                    ->prepare("INSERT INTO payment (school_id, user_id, reference_no, amount, price, kdv, discount, school_type, package) 
                VALUES (".$cart_item['school_id'].", ".$_POST['user_id'].",
                 '".$reference_no."', ".$_POST['total_price'].", ".$_POST['price'].", ".$_POST['kdv'].",
                 ".$_POST['total_discount'].",  ".$cart_item['type'].", 'Premium')");
                    $this->db->statement->execute();
            }



            $this->db->statement = $this->db->databaseHandler->prepare("delete from cart where user_id =".$_POST['user_id']);
            $this->db->statement->execute();
        }
    }

    
   public function get_selected_user() {
       if (isset($_POST['selected_user']) && $_POST['selected_user'] != ''){
           $this->db->statement = $this->db->databaseHandler->prepare("select first_name, last_name, phone, email from user where id =".$_POST['selected_user']);
           $this->db->statement->execute();
           $fetchData = $this->db->statement->fetch();
       }
       $data = array();
       if($fetchData) {
           $data[] = array(
               'first_name' => $fetchData['first_name'],
               "last_name"=>$fetchData['last_name'],
               'phone' => $fetchData ['phone'],
               'email' => $fetchData ['email']
           );
       } else {
           $data[] = array(
               'first_name' => '',
               "last_name"=>'',
               'phone' => '',
               'email' => ''
           );
       }
       echo json_encode($data, JSON_UNESCAPED_UNICODE);
   }

    public function get_school_type() {
        $fiyat = 0;
        if (isset($_POST['selected_school']) && $_POST['selected_school'] > 0){
            $this->db->statement = $this->db->databaseHandler->prepare("select type from school where id =".$_POST['selected_school']);
            $this->db->statement->execute();
            $fetchData = $this->db->statement->fetch();

            if($fetchData['type'] == 1) { //Anaokulu
                $fiyat = '2.500';
            } else if ($fetchData['type'] == 2) { //İlkokul
                $fiyat = '4.500';
            } else if ($fetchData['type'] == 3) { //Ortaokul
                $fiyat = '4.500';
            } else { //Lise
                $fiyat = '4.500';
            }

        }
        $data = array();
        if($fetchData) {
            $data[] = array(
                'okul_turu' => $fetchData['type'],
                'fiyat' => $fiyat
            );
        } else {
            $data[] = array(
                'okul_turu' => '',
                'fiyat' => $fiyat
            );
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function mb_strtolower_turkce($metin){
        $bul 	= array("I");
        $degis  = array("ı");
        $metin	= str_replace($bul, $degis, $metin);
        $metin	= mb_strtolower($metin,'utf-8');
        return $metin;
    }

    public function previewanswer() {
        $fetchData = array();

        if (isset($_POST['question']) && $_POST['question'] != ''){
            $this->db->statement = $this->db->databaseHandler->prepare("select answer, sss_answer_type, sss_style from sss where link ='".$_POST['question']."'");
            $this->db->statement->execute();
            $fetchDataQuestion = $this->db->statement->fetch();

            if (isset($_POST['selected_school']) && $_POST['selected_school'] != '' &&
                $fetchDataQuestion['sss_answer_type'] == 'otomatik'){

                $this->db->statement = $this->db->databaseHandler->prepare("select * from school where id =".$_POST['selected_school']." and state = 2");
                $this->db->statement->execute();
                $fetchDataSchool = $this->db->statement->fetch();
                if($fetchDataSchool && $_POST['sss_connection'] == 'servis' || $_POST['sss_connection'] == 26) {
                    $this->db->statement = $this->db->databaseHandler->prepare("select name from town where ilce_key in( SELECT ilce_key FROM `transportation_point` WHERE school_id = ".$_POST['selected_school'].")");
                    $this->db->statement->execute();
                    $fetchDataServis = $this->db->statement->fetchAll();
                    $answer = '';
                    $counter = 0;
                    if($fetchDataQuestion['sss_style'] == 'yazi') {
                        foreach($fetchDataServis as $dataServis) {
                            if($counter == count($fetchDataServis)-1) {
                                $answer = $answer.ucfirst($this->mb_strtolower_turkce($dataServis['name']));
                            } else {
                                $answer = $answer.ucfirst($this->mb_strtolower_turkce($dataServis['name'])).', ';
                            }
                            $counter++;
                        }
                        $bolge = $counter > 1 ? 'bölgelerinde ' : 'bölgesinde ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer.' '.$bolge, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuz '.$answer.' '.$bolge.'servis hizmeti vermektedir.';
                        }
                        $fetchData[] = $answer;


                    } else {
                        $answer = '<ul>';
                        foreach($fetchDataServis as $dataServis) {
                            if($counter == count($fetchDataServis)-1) {
                                $answer = $answer.'<li>'.ucfirst($this->mb_strtolower_turkce($dataServis['name'])).'</li></ul>';
                            } else {
                                $answer = $answer.'<li>'.ucfirst($this->mb_strtolower_turkce($dataServis['name'])).'</li>';
                            }
                            $counter++;
                        }
                        $bolge = $counter > 1 ? 'bölgelerinde ' : 'bölgesinde ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer.' '.$bolge, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuzun aşağıdaki servis '.$bolge.'hizmet vermektedir : '.$answer;
                        }
                        $fetchData[] = $answer;

                    }

                } else if($fetchDataSchool && $_POST['sss_connection'] == 'yas-araligi') {
                    $this->db->statement = $this->db->databaseHandler->prepare("SELECT age_interval FROM `school` where id =".$_POST['selected_school']);
                    $this->db->statement->execute();
                    $fetchDataYas = $this->db->statement->fetch();

                    $answer = $fetchDataYas['age_interval'];

                    if($fetchDataYas['age_interval'] && $fetchDataYas['age_interval'] != '') {
                        $answer = str_replace('{xxxx}', $answer, $fetchDataQuestion['answer']);
                    }
                    $fetchData[] = $answer;

                } else if($fetchDataSchool && $_POST['sss_connection'] == 'okul-saatleri') {
                    $this->db->statement = $this->db->databaseHandler->prepare("SELECT monday_start, monday_end FROM `school_hours` where school_id =".$_POST['selected_school']);
                    $this->db->statement->execute();
                    $fetchDataHours = $this->db->statement->fetch();

                    $dateStart = new DateTime($fetchDataHours['monday_start']);
                    $dateEnd = new DateTime($fetchDataHours['monday_end']);

                    $answer = $dateStart->format('H:i').' - '.$dateEnd->format('H:i');

                    if($fetchDataHours && $fetchDataHours['monday_start'] != '' && $fetchDataHours['monday_end'] != '') {
                        $answer = str_replace('{xxxx}', $answer, $fetchDataQuestion['answer']);
                    }
                    $fetchData[] = $answer;

                } else if($fetchDataSchool && $_POST['sss_connection'] == 'danisman' || $_POST['sss_connection'] == 24) {
                    $answer = '';
                    if($fetchDataQuestion['answer'] != '') {
//                        $answer = str_replace('{xxxx}', $answer, $fetchDataQuestion['answer']);
                    } else {
//                        $answer = 'Okulumuz '.$answer.' servis hizmeti vermektedir.';
                    }
                    $fetchData[] = $answer;
                } else if($fetchDataSchool && $_POST['sss_connection'] == 'fiziksel-imkanlar') {

                    $this->db->statement = $this->db->databaseHandler->prepare("SELECT name FROM `facility` WHERE type=1 and id IN (select facility_id from school_facility where school_id = ".$_POST['selected_school'].")");
                    $this->db->statement->execute();
                    $fetchDataImkan = $this->db->statement->fetchAll();
                    $answer = '';
                    $counter = 0;
                    if($fetchDataQuestion['sss_style'] == 'yazi') {
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.$dataImkan['name'];
                            } else {
                                $answer = $answer.$dataImkan['name'].', ';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'imkanları ' : 'imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer.' '.$imkan, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuzda '.$answer.' '.$imkan.'bulunmaktadır.';
                        }
                        $fetchData[] = $answer;


                    } else {
                        $answer = '<ul>';
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li></ul>';
                            } else {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li>';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'imkanları ' : 'imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuz aşağıdaki '.$imkan.'sağlamaktadır : '.$answer;
                        }
                        $fetchData[] = $answer;

                    }


                } else if($fetchDataSchool && $_POST['sss_connection'] == 'servisler') {

                    $this->db->statement = $this->db->databaseHandler->prepare("SELECT name FROM `facility` WHERE type=2 and id IN (select facility_id from school_facility where school_id = ".$_POST['selected_school'].")");
                    $this->db->statement->execute();
                    $fetchDataImkan = $this->db->statement->fetchAll();
                    $answer = '';
                    $counter = 0;
                    if($fetchDataQuestion['sss_style'] == 'yazi') {
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.$dataImkan['name'];
                            } else {
                                $answer = $answer.$dataImkan['name'].', ';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'imkanları ' : 'imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer.' '.$imkan, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuzda '.$answer.' '.$imkan.'bulunmaktadır.';
                        }
                        $fetchData[] = $answer;


                    } else {
                        $answer = '<ul>';
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li></ul>';
                            } else {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li>';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'imkanları ' : 'imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuz aşağıdaki '.$imkan.'sağlamaktadır : '.$answer;
                        }
                        $fetchData[] = $answer;

                    }


                } else if($fetchDataSchool && $_POST['sss_connection'] == 'aktiviteler') {

                    $this->db->statement = $this->db->databaseHandler->prepare("SELECT name FROM `facility` WHERE type=3 and id IN (select facility_id from school_facility where school_id = ".$_POST['selected_school'].")");
                    $this->db->statement->execute();
                    $fetchDataImkan = $this->db->statement->fetchAll();
                    $answer = '';
                    $counter = 0;
                    if($fetchDataQuestion['sss_style'] == 'yazi') {
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.$dataImkan['name'];
                            } else {
                                $answer = $answer.$dataImkan['name'].', ';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'imkanları ' : 'imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer.' '.$imkan, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuzda '.$answer.' '.$imkan.'bulunmaktadır.';
                        }
                        $fetchData[] = $answer;


                    } else {
                        $answer = '<ul>';
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li></ul>';
                            } else {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li>';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'imkanları ' : 'imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuz aşağıdaki '.$imkan.'sağlamaktadır : '.$answer;
                        }
                        $fetchData[] = $answer;

                    }


                } else if($fetchDataSchool && $_POST['sss_connection'] == 'yabanci-diller') {

                    $this->db->statement = $this->db->databaseHandler->prepare("SELECT name FROM `facility` WHERE type=4 and id IN (select facility_id from school_facility where school_id = ".$_POST['selected_school'].")");
                    $this->db->statement->execute();
                    $fetchDataImkan = $this->db->statement->fetchAll();
                    $answer = '';
                    $counter = 0;
                    if($fetchDataQuestion['sss_style'] == 'yazi') {
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.$dataImkan['name'];
                            } else {
                                $answer = $answer.$dataImkan['name'].', ';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'yabancı dil imkanları ' : 'yabancı dil imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer.' '.$imkan, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuzda '.$answer.' '.$imkan.'bulunmaktadır.';
                        }
                        $fetchData[] = $answer;


                    } else {
                        $answer = '<ul>';
                        foreach($fetchDataImkan as $dataImkan) {
                            if($counter == count($fetchDataImkan)-1) {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li></ul>';
                            } else {
                                $answer = $answer.'<li>'.$dataImkan['name'].'</li>';
                            }
                            $counter++;
                        }
                        $imkan = $counter > 1 ? 'yabancı dil imkanları ' : 'yabancı dil imkanı ';
                        if($fetchDataQuestion['answer'] != '') {
                            $answer = str_replace('{xxxx}', $answer, $fetchDataQuestion['answer']);
                        } else {
                            $answer = 'Okulumuz aşağıdaki '.$imkan.'sağlamaktadır : '.$answer;
                        }
                        $fetchData[] = $answer;

                    }


                } else {
                    $this->db->statement = $this->db->databaseHandler->prepare("SELECT name FROM `facility` where id IN (select facility_id from school_facility where facility_id=".$_POST['sss_connection']." AND school_id = ".$_POST['selected_school'].")");
                    $this->db->statement->execute();
                    $fetchDataImkan = $this->db->statement->fetchAll();
                    $answer = '';
                    $counter = 0;
                    foreach($fetchDataImkan as $dataImkan) {
                        if($counter == count($fetchDataImkan)-1) {
                            $answer = $answer.$dataImkan['name'];
                        } else {
                            $answer = $answer.$dataImkan['name'].', ';
                        }
                        $counter++;
                    }
                    $imkan = $counter > 1 ? 'imkanları ' : 'imkanı ';
                    if($fetchDataQuestion['answer'] != '') {
                        $answer = str_replace('{xxxx}', $answer.' '.$imkan, $fetchDataQuestion['answer']);
                    } else {
                        $answer = 'Okulumuzda '.$answer.' '.$imkan.'bulunmaktadır.';
                    }
                    $fetchData[] = $answer;



                }


            }
        }

        $data = array();
        if($fetchData) {
            $data[] = array(
                'answer' => $fetchData[0]
            );
        } else {
            $data[] = array(
                'answer' => ''
            );
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    protected function towns() {
        if (!isset($_POST['searchTerm']) || $_POST['searchTerm'] == ''){
            $this->db->statement = $this->db->databaseHandler->prepare("select id,ilce_key,name from town where ilce_sehirkey =".$_POST['selectedCity']." order by name ");
            $this->db->statement->execute();
            $fetchData = $this->db->statement->fetchAll();
        } else{
            $search = $_POST['searchTerm'];
            $this->db->statement = $this->db->databaseHandler->prepare("select id, ilce_key,name from town where ilce_sehirkey =".$_POST['selectedCity']." AND name like '%".$search."%' order by name");
            $this->db->statement->execute();
            $fetchData = $this->db->statement->fetchAll();
        }
            $data = array();
            foreach($fetchData as $row){
               $data[] = array(
                   'id' => $row['ilce_key'],
                   "text"=>$row['name']
                 );
            }     
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
       
    }

    protected function subtowns() {
        if (!isset($_POST['searchTerm'])){
            $this->db->statement = $this->db->databaseHandler->prepare("select mahalle_key,name from subtown where mahalle_ilcekey = ".$_POST['selectedTown']." order by name");
            $this->db->statement->execute();
            $fetchData = $this->db->statement->fetchAll();
        } else{
            $search = $_POST['searchTerm'];
            $this->db->statement = $this->db->databaseHandler->prepare("select id,mahalle_key,name from subtown where name like '%".$search."%' AND mahalle_ilcekey =".$_POST['selectedTown']);
            $this->db->statement->execute();
            $fetchData = $this->db->statement->fetchAll();
        }
        $data = array();
        foreach($fetchData as $row){
            $data[] = array(
                'id' => $row['mahalle_key'],
                "text"=>$row['name']
            );
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

    }
    
    
    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }
    
}

