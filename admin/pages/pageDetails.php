<?php
if (!(isset($_GET["url"]) && $_GET["url"])) {
    $titlepage =  "Add New Page";
    $submitBtn = "Submit";
} else {
    $titlepage = "Edit Page Details";
    $submitBtn = "Update";
}

$title = $titlepage . " | CMS";
include '../../layout.php';
include '../include/header.php';
include '../../services/pages/getPageAllDetails.php';


//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}
?>

<body>
    <div class="container">
        <div>
            <h3><?php echo $titlepage ?>
            </h3>
        </div>
        <div class="my-4 mx-5">
            <form action="<?php echo $pageDetails ? "/services/pages/updatePageDetails.php" : "/services/pages/addNewPage.php" ?>" method="post" enctype="multipart/form-data" onSubmit="return validate();">

                <div class="mb-3">
                    <div class="form-group">
                        <label class="mb-2 form-label" for="title">Page Title </label>
                        <input type="text" class="form-control" placeholder="Title" name="title" id="title" onkeypress="return /[a-zA-Z ]/i.test(event.key)" autofocus required maxlength="100" value="<?php echo $pageDetails ?  $pageDetails['title'] : "" ?>">
                        <div id="titleError" class="d-none inputError"></div>
                        <?php echo $pageDetails ?  '<input type="hidden" value="' . $_GET["url"] . '" name="url"' : "" ?>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="mb-2 form-label" for="description">Page Description </label>
                        <textarea rows="5" class="form-control" placeholder="Description" name="description" id="description" required maxlength="4500"><?php echo $pageDetails ?  $pageDetails['description'] : "" ?></textarea>
                    </div>
                </div>
                <div class="row mb-4 m-0">

                    <div class="row" data-type="imagesloader_new" data-errorformat="Accepted file formats" data-errorsize="Maximum size accepted" data-errorduplicate="File already loaded" data-errormaxfiles="Maximum number of images you can upload" data-errorminfiles="Minimum number of images to upload" data-modifyimagetext="Modify immage">

                        <!-- Progress bar -->
                        <div class="col-12 order-1 mt-2">
                            <div data-type="progress" class="progress" style="height: 25px; display:none;">
                                <div data-type="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 100%;">Load in progress...</div>
                            </div>
                        </div>

                        <!-- Model -->
                        <div data-type="image-model" class="col-3 pl-2 pr-2 pt-2" style="max-width:120px; display:none;">

                            <div class="ratio-box text-center" data-type="image-ratio-box">
                                <img data-type="noimage" class="btn btn-light ratio-img img-fluid p-0 image border dashed rounded" src="/public/img/photo-camera-gray.svg" style="cursor:pointer;">
                                <div data-type="loading" class="img-loading" style="color:#218838; display:none;">
                                    <span class="fa fa-2x fa-spin fa-spinner"></span>
                                </div>
                                <img data-type="preview" class="btn btn-light ratio-img img-fluid p-0 image border dashed rounded" src="" style="display: none; cursor: default;">
                                <span class="badge badge-pill badge-primary p-2 w-50 main-tag" style="display:none;">Main</span>
                            </div>

                            <!-- Buttons -->
                            <div data-type="image-buttons" class="row justify-content-center mt-2">
                                <button data-type="add" class="btn btn-primary btn-sm" type="button"><span class="fas fa-plus mr-1"></span>Add Images</button>
                                <button data-type="btn-modify" type="button" class="btn btn-primary btn-sm m-0" data-toggle="popover" data-placement="right" style="display:none;z-index: 1;">
                                    <span class="ti-slice mr-2"></span>Modify
                                </button>
                            </div>
                        </div>

                        <!-- Popover operations -->
                        <div data-type="popover-model" style="display:none">
                            <div data-type="popover" class="ml-3 mr-3" style="min-width:150px;">
                                <div class="row">
                                    <div class="col p-0">
                                        <button data-operation="main" class="btn btn-block btn-primary btn-sm rounded-pill" type="button"><span class="fa fa-angle-double-up mr-2"></span>Main</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6 p-0 pr-1">
                                        <button data-operation="left" class="btn btn-block btn-outline-primary btn-sm rounded-pill" type="button"><span class="fa fa-angle-left mr-2"></span>Left</button>
                                    </div>
                                    <div class="col-6 p-0 pl-1">
                                        <button data-operation="right" class="btn btn-block btn-outline-primary btn-sm rounded-pill" type="button">Right<span class="fa fa-angle-right ml-2"></span></button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6 p-0 pr-1">
                                        <button data-operation="rotateanticlockwise" class="btn btn-block btn-outline-primary btn-sm rounded-pill" type="button"><span class="fas fa-undo-alt mr-2"></span>Rotate</button>
                                    </div>
                                    <div class="col-6 p-0 pl-1">
                                        <button data-operation="rotateclockwise" class="btn btn-block btn-outline-primary btn-sm rounded-pill" type="button">Rotate<span class="fas fa-redo-alt ml-2"></span></button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <button data-operation="remove" class="btn btn-outline-danger btn-sm btn-block" type="button"><span class="fa fa-times mr-2"></span>Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <!--Hidden file input for images-->
                                <input id="files" type="file" name="files[]" data-button="" multiple="" accept="image/jpeg, image/png, image/gif," style="display:none;">
                                <input id="blobFileName" type="hidden" name="blobFileName">
                                <input id="blobFileData" type="hidden" name="blobFileData">
                            </div>
                        </div>

                    </div>
                    <div id="imageError" class="d-none inputError"></div>

                    <div class="form-group col-md-6 " style="display:none;">
                        <label for="image" class="form-label">Feature Image</label>
                        <input class="form-control" type="file" name="image" id="image" accept=".jpg" value="<?php echo $pageDetails ?  $pageDetails['image'] : "" ?>">
                    </div>
                    <div class="col-md-6 mt-c2 p-0" style="display:none;">
                        <img src="<?php echo $pageDetails ? "../../" . $pageDetails['image'] : "" ?>" class="img-fluid rounded <?php echo $pageDetails ? "" : "d-none" ?>" alt="Responsive image" style="max-height:75px" width="100%" id="imagePreview">
                        <div id="imagePreviewText" class="image-preview-text border <?php echo $pageDetails ? "d-none" : "" ?>"> Select a feture image</div>
                    </div>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="published" <?php echo $pageDetails ? ($pageDetails['status'] == '1' ? "checked" : "") : "checked" ?> name="published">
                    <label class="form-check-label" for="published">Published</label>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5"> <?php echo $submitBtn ?>
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script src="/public/js/jquery.imagesloader-1.0.1.js"></script>
    <script>
        var auctionImagesEdit = [
            <?php if ($pageImage) { ?> {
                    "Url": "<?php echo $pageImage ?  $pageImage : '' ?>",
                    "Name": "Uploded Image"
                }
            <?php } ?>
        ];

        // Create image loader plugin
        var imagesloader = $('[data-type=imagesloader_new]').imagesloader({
            fadeTime: 'fast',
            inputID: 'image',
            maxfiles: 1,
            imagesToLoad: auctionImagesEdit
        });

        function validate() {
            $(".inputError").each(function() {
                $(this).addClass("d-none")
            });

            var title = $("#title").val();
            var image = $("#image").val();
            var valid = true;

            if (title.length <= 3 || !RegExp("^[a-zA-Z]").test(title)) {
                $("#titleError").removeClass("d-none");
                $("#titleError").text("Invalid title.");
                valid = false;
            }

            var files = imagesloader.data('format.imagesloader').AttachmentArray;

            if (files.length) {
                $("#blobFileName").val(files[0]['FileName']);
                $("#blobFileData").val(files[0]['Base64']);
            } else {
                $("#imageError").text("Please Select Image");
                $("#imageError").removeClass("d-none");
                return false;
            }

            if (!valid)
                return false;

        }
    </script>
</body>