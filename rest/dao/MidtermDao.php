<?php
define("DB_NAME", "midterm");
define("DB_PORT", 3306);
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_HOST", "127.0.0.1");
class MidtermDao {

    private $connection;
    private $table;

    /**
    * constructor of dao class
    */
    public function __construct($table = "cap_table"){
      $this->table = $table;
        try {
        /** TODO
        * List parameters such as servername, username, password, schema. Make sure to use appropriate port
        */
        //listed them above since the code looks neater this way
        /** TODO
        * Create new connection
        * Use $options array as last parameter to new PDO call after the password
        */
        $options=[
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $this->connection = new PDO(
          "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,
          DB_USER,
          DB_PASSWORD, 
          $options
      );

        // set the PDO error mode to exception
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
    * Implement DAO method used to get cap table
    */
    public function cap_table(){
      $query = "SELECT * FROM cap_table";
      $statement = $this->connection->query($query);
      $cap = $statement->fetchAll();
      return $cap;
    }

    /** TODO
    * Implement DAO method used to add cap table record
    */
    public function add_cap_table_record($diluted_shares){
      $query = "INSERT INTO cap_table (diluted_shares)
                  VALUES (:diluted_shares)";
        $statement = $this->connection->prepare($query);
      $statement->execute([':diluted_shares' => $diluted_shares]);
      return $this->connection->lastInsertId();

    }

    /** TODO
    * Implement DAO method to return list of categories with total shares amount????
    */
    public function categories(){
      $query = "SELECT share_class_category_id, SUM(diluted_shares) as total_shares FROM cap_table GROUP BY share_class_category_id";
      $statement = $this->connection->query($query);
      $categories = $statement->fetchAll();
      return $categories;
    
    }

    /** TODO
    * Implement DAO method to delete investor
    */
    public function delete_investor($id){
      $this->execute("DELETE FROM investros WHERE id = :id", ["id" => $id]);
    }
}
?>
