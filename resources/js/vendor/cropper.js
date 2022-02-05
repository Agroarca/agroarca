const Cropper = require("cropperjs");

class CropperUtils {
    constructor() {
        this.oj = null;
        this.width = 800;
        this.height = 600;

        this.options = {
            aspectRatio: this.width / this.height,
            dragMode: "move",
            responsive: true,
            viewMode: 3,
            cropBoxResizable: false,
            ready: this.ready,
        };

        this.init();
    }

    init() {
        let cropper = this;
        $(document).ready(function () {
            $(".crop-image-upload").on("change", cropper.readImage);
            $(".crop-modal").on("shown.bs.modal", cropper.startCropper);
            $(".crop-modal").on("hidden.bs.modal", cropper.destroyCropper);
            $(".crop-save").on("click", cropper.saveCrop);
        });
    }

    ready() {
        let containerData = this.cropper.getContainerData();

        this.cropper.setCropBoxData({
            width: cropper.width,
            height: cropper.height,
            left: (containerData.width - cropper.width) / 2,
            top: (containerData.height - cropper.height) / 2,
        });
    }

    readImage(event) {
        let files = event.target.files;

        if (!files || files.length < 1) {
            return;
        }

        let imgObj = new Image();
        var imgObjUrl = URL.createObjectURL(files[0]);
        imgObj.onload = function () {

            if (this.width !== cropper.width || this.height !== cropper.height) {
                cropper.setupCropper(files[0]);
            }

            URL.revokeObjectURL(imgObjUrl);
        };
        imgObj.src = imgObjUrl;
    }

    setupCropper(file) {
        reader = new FileReader();

        reader.onload = function (event) {
            document.querySelector(".crop-image").src = reader.result;
            $(".crop-modal").modal("show");
        };

        reader.readAsDataURL(file);
    }

    startCropper() {
        let image = document.querySelector(".crop-image");
        cropper.obj = new Cropper(image, cropper.options);
    }

    destroyCropper() {
        cropper.obj.destroy();
        cropper.obj = null;
    }

    saveCrop() {
        canvas = cropper.obj.getCroppedCanvas({
            width: cropper.width,
            height: cropper.height,
        });

        canvas.toBlob(
            function (blob) {
                let file = new File([blob], "imagem.png", {
                    type: "image/png",
                    lastModified: new Date().getTime(),
                });

                let container = new DataTransfer();
                container.items.add(file);
                document.querySelector(".crop-image-upload").files =
                    container.files;
            },
            "image/png",
            1
        );

        $(".crop-modal").modal("hide");
    }
}

const cropper = new CropperUtils();
