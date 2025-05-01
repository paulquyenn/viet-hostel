@props(['route', 'name', 'id', 'imgs' => null])

@vite(['resources/js/app.js'])
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .dropzone {
        background: #191c24 !important;
    }

    .dz-preview {
        position: relative;
    }

    .dz-preview .dz-remove {
        background: transparent;
        color: #ff0000;
        border: none;
        padding: 0;
        cursor: pointer;
        position: absolute;
        top: 5px;
        right: 5px;
        display: block;
        z-index: 1000;
    }

    .dz-preview .dz-remove i {
        font-size: 20px;
        cursor: pointer;
    }

    .dz-preview.selected {
        border: 2px solid #00ff00;
    }

    .dz-preview.selected .dz-remove {
        display: none;
    }

    .dropzone .dz-preview .dz-image img {
        width: 120px;
        /* Điều chỉnh kích thước theo ý bạn */
        height: 120px;
    }
</style>

<section>
    <div id="dropzone">
        <form class="dropzone needsclick dropzone" id="upload" method="POST" action="{{ $route }}">
            @csrf
            <input type="hidden" name="{{ $name }}" value="{{ $id }}">
            <div class="dz-message needsclick">
                Drop files here or click to upload.<br>
            </div>
            <button style="display:none;" class="button-submit-files" type="submit">Submit file!</button>
        </form>
    </div>
</section>

<script>
    const arrFiles = [];
    document.addEventListener('DOMContentLoaded', function() {
        var dropzone = new Dropzone('#upload', {
            url: "{{ $route }}",
            method: "post",
            addRemoveLinks: true,
            autoProcessQueue: true,
            uploadMultiple: true,
            maxFiles: 5,
            parallelUploads: 100,
            init: function() {
                var myDropzone = this;

                this.element.querySelector("button[type=submit]").addEventListener("click",
                    function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });

                const imgs = @json($imgs);
                if (imgs) {
                    arrFiles.push(...imgs);
                    imgs.forEach(img => {
                        var mockFile = {
                            name: img.name,
                            size: img.size,
                            id: img.id,
                            accepted: true,
                            thumbnail: 100,
                            status: Dropzone.ADDED,
                            url: '/storage/' + img.path
                        };
                        myDropzone.displayExistingFile(mockFile, '/storage/' + img.path);
                    })
                }

                this.on("sendingmultiple", function() {});
                this.on("successmultiple", function(files, response) {
                    console.log('Upload success:', response);
                    arrFiles.push(...response.data);
                });
                this.on("errormultiple", function(files, response) {
                    console.error('Upload error:', response);
                });
                this.on("removedfile", function(file) {
                    console.log('File removed:', file);
                    console.log('arrFiles:', arrFiles);
                    const fileRm = arrFiles.find((f) => f.name === file.name);
                    if (file.status === 'success' || fileRm && fileRm.id) {
                        $.ajax({
                            type: 'POST',
                            url: `{{ $route }}/${fileRm.id}`,
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}",
                                id: file.id
                            },
                            success: function(data) {
                                console.log('File removed:', data);
                            },
                            error: function(data) {
                                console.error('File removed:', data);
                            }
                        });
                    }
                });
            },
        });

        const btnSubmit = document.querySelector('.btn-submit');
        if (btnSubmit) {
            btnSubmit.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.button-submit-files').click();
                this.closest('form').submit();
            });
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
