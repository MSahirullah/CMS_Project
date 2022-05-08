<?php
class Page
{
    public function addNewPage($data, $conn)
    {
        $title = isset($data['title']) ? $data['title'] : '';
        $description = isset($data['description']) ? $data['description'] : '';
        $published = isset($data['published']) ? 1 : 0;
        $url = $this->slugify($title);
        $uploadedFile = '';

        if (isset($data['blobFileName']) && $data['blobFileName'] && isset($data['blobFileData']) && $data['blobFileData']) {

            $imgA = str_replace('data:image/jpeg;base64,', '', $data['blobFileData']);
            $imgB = str_replace(' ', '+', $imgA);
            $ImageData = base64_decode($imgB);

            $uploadFileName = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', pathinfo($data['blobFileName'], PATHINFO_FILENAME)))) . '.jpg';

            mkdir("../../public/post_images/" . $url . '/');
            $target_dir = "../../public/post_images/" . $url . '/';
            $target_file = $target_dir . $uploadFileName;

            if (file_put_contents($target_file, $ImageData)) {
                $uploadedFile = "../../public/post_images/" . $url . "/" . $uploadFileName;
            }
        }

        if ($title && $description && $url && $uploadedFile) {

            $new_page_sql = "INSERT INTO pages(title, description, url , image, status ) VALUES(:title, :description, :url, :image, :status)";

            $statement = $conn->prepare($new_page_sql);

            $statement->execute([
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'image' => $uploadedFile,
                'status' => $published
            ]);

            $_SESSION['page_status'] = ['alert-success', 'New page added successfully.'];
            Header("Location: /admin/pages/index.php");
            exit();
        }

        $_SESSION['page_status'] = ['alert-danger', 'Something went wrong, Please try again'];
        Header("Location: /admin/pages/index.php");
        exit();
    }

    public function updatePage($data, $files, $conn)
    {
        $title = isset($data['title']) ? $data['title'] : '';
        $description = isset($data['description']) ? $data['description'] : '';
        $published = isset($data['published']) ? 1 : 0;

        $url = isset($data['url']) ? $data['url'] : '';
        $uploadedFile = '';

        if (isset($data['blobFileName']) && $data['blobFileName'] && isset($data['blobFileData']) && $data['blobFileData']) {

            $selectQuery = "SELECT image FROM pages WHERE url=:url";
            $page = $conn->prepare($selectQuery);
            $page->execute([
                'url' => $url,
            ]);

            unlink($page->fetch(PDO::FETCH_ASSOC)['image']);

            $imgA = str_replace('data:image/jpeg;base64,', '', $data['blobFileData']);
            $imgB = str_replace(' ', '+', $imgA);
            $ImageData = base64_decode($imgB);

            $uploadFileName = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', pathinfo($data['blobFileName'], PATHINFO_FILENAME)))) . '.jpg';

            $target_dir = "../../public/post_images/" . $url . '/';
            $target_file = $target_dir . $uploadFileName;

            if (file_put_contents($target_file, $ImageData)) {
                $uploadedFile = "../../public/post_images/" . $url . "/" . $uploadFileName;
            }
        }

        if ($title && $description && $url && $uploadedFile) {

            $new_page_sql = "UPDATE pages SET title=:title, description=:description, image=:image, status=:status WHERE url=:url";

            $statement = $conn->prepare($new_page_sql);

            $statement->execute([
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'image' => $uploadedFile,
                'status' => $published
            ]);
            $_SESSION['page_status'] = ['alert-success', 'Page details updated successfully.'];
            Header("Location: /admin/pages/index.php");
            exit();
        }

        $_SESSION['page_status'] = ['alert-danger', 'Something went wrong, Please try again'];
        Header("Location: /admin/pages/index.php");
        exit();
    }

    public function getPages($conn)
    {
        $query = "SELECT url, title, description, image, status FROM pages WHERE status=:status ORDER BY id DESC";
        $pages = $conn->prepare($query);
        $pages->execute(['status' => '1']);
        return $pages;
    }
    public function getAllPages($conn)
    {
        $query = "SELECT * FROM pages  ORDER BY id DESC";
        $pages = $conn->prepare($query);
        $pages->execute();
        return $pages;
    }

    public function getPageContent($url, $conn)
    {
        $query = "SELECT title, description, image, url, status FROM pages WHERE url=:url";
        $page = $conn->prepare($query);
        $page->execute([
            'url' => $url,
        ]);
        $data = $page->fetch(PDO::FETCH_ASSOC);

        $uploadedImage = $data['image'];

        if ($page->rowCount()) {
            return ['pageData' => $data, 'uploadedimage' => $uploadedImage];
        }
    }

    public function deletePage($url, $conn)
    {
        if ($url) {
            $selectQuery = "SELECT image FROM pages WHERE url=:url";
            $page = $conn->prepare($selectQuery);
            $page->execute([
                'url' => $url,
            ]);
            $file_path = str_replace(" ", "", '../../public/post_images/' . $url . '/');

            unlink($page->fetch(PDO::FETCH_ASSOC)['image']);
            rmdir($file_path);

            $query = "DELETE FROM pages WHERE url=:url";
            $page = $conn->prepare($query);
            $page->execute([
                'url' => $url,
            ]);

            print_r($page->rowCount());
            $_SESSION['page_status'] = ['alert-success', 'Page deleted successfully.'];
            exit();
        }

        $_SESSION['page_status'] = ['alert-danger', 'Something went wrong, Please try again'];
        exit();
    }

    public  function slugify($string)
    {
        $string = $string . '-' . hash('ripemd160', time());
        $slug = trim($string);
        $slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $slug);
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower($slug);
        return $slug;
    }
}
