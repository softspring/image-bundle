var imageTypeModal = document.getElementById('imageTypeModal')

if (imageTypeModal) {
    /**
     * Open modal
     */
    imageTypeModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        imageTypeModal.clickedButton = event.relatedTarget
        const imageInput = document.getElementById(imageTypeModal.clickedButton.dataset.imageTypeField);

        var imageTypeModalBody = imageTypeModal.querySelector('.modal-body');
        var imageTypeModalFooter = imageTypeModal.querySelector('.modal-footer');
        imageTypeModal.querySelector('[data-image-type-select]').classList.add('disabled');

        imageTypeModalFooter.style.setProperty('display', 'none');

        imageTypeModalBody.innerHTML = '<div class="p-5 text-center"><div class="spinner-border text-secondary" role="status">\n' +
            '  <span class="visually-hidden">Loading...</span>\n' +
            '</div></div>';

        // get valid types
        var imageTypes = imageInput.getAttribute('data-image-type-types')

        var url = imageTypeModal.clickedButton.dataset.searchUrl; // + '?page=1&rpp=&order=&text=&' + imageTypes.split(',').map((v) => 'valid_types%5B%5D=' + v).join('&');
        loadSearchPage(url);
    });

    /**
     * Load modal page with image list
     */
    function loadSearchPage(url) {
        var imageTypeModalBody = imageTypeModal.querySelector('.modal-body');
        var imageTypeModalFooter = imageTypeModal.querySelector('.modal-footer');

        var http_request = new XMLHttpRequest();
        http_request.onreadystatechange = function () {
            if (http_request.readyState === 4) {
                imageTypeModalBody.innerHTML = http_request.response;
                imageTypeModalFooter.style.setProperty('display', '');

                imageTypeModal.querySelector('[data-image-type-select]').classList.add('disabled');

                var searchForm = imageTypeModalBody.querySelector('form');
                searchForm.onsubmit = function (event) {
                    event.preventDefault();

                    const formData = new FormData(event.target);
                    const data = [...formData.entries()];
                    const asString = data
                        .map(x => `${encodeURIComponent(x[0])}=${encodeURIComponent(x[1])}`)
                        .join('&');

                    loadSearchPage(searchForm.action + '?' + asString);
                }
            }
        };
        http_request.open('GET', url, true);
        http_request.send();
    }

    /**
     * Click on modal image, to be selected
     */
    document.addEventListener('click', function (event) {
        var image = null;
        if (!event.target || !event.target.hasAttribute('data-image-type')) {
            for (i = 0; i < event.composedPath().length; i++) {
                if (event.composedPath()[i] instanceof Element && event.composedPath()[i].matches('[data-image-type]')) {
                    image = event.composedPath()[i];
                    break;
                }
            }

            if (!image) {
                return;
            }
        } else {
            image = event.target;
        }

        imageTypeModal.querySelectorAll('.sfs-image-selected').forEach(function (element) {
            element.classList.remove('sfs-image-selected');
        });

        image.classList.add('sfs-image-selected');

        imageTypeModal.querySelector('[data-image-type-select]').classList.remove('disabled');
    });

    /**
     * Click on modal Select button, to commit selection
     */
    document.addEventListener('click', function (event) {
        if (!event.target || !event.target.hasAttribute('data-image-type-select')) return;
        const selectedImage = imageTypeModal.querySelector('.sfs-image-selected');
        if (!selectedImage) {
            return;
        }

        const imageInput = document.getElementById(imageTypeModal.clickedButton.dataset.imageTypeField);

        // sets input hidden value and data elements
        imageInput.value = selectedImage.dataset.imageId;
        // propagate data version
        for (let key in selectedImage.dataset) {
            if (!key.match(/^imageVersion/i)) {
                continue;
            }
            imageInput.dataset[key] = selectedImage.dataset[key];
        }

        // show image name
        document.getElementById(imageTypeModal.clickedButton.dataset.imageTypeField + '_text').innerHTML = selectedImage.dataset.imageName;

        // show thumbnail on widget
        const widget = document.getElementById(imageTypeModal.clickedButton.dataset.imageTypeWidget);
        const thumbnail = widget.querySelector('[data-image-type-thumbnail]');
        if (thumbnail) {
            thumbnail.innerHTML = imageInput.dataset['imageVersion-_thumbnail'];
        }

        // hides modal
        window.bootstrap.Modal.getInstance(imageTypeModal).hide();

        // dispatches image selected event
        imageInput.dispatchEvent(new Event('sfs_image.selected', {bubbles: true}));
    });

    /**
     * Click on form clean button, to unselect image
     */
    document.addEventListener('click', function (event) {
        if (!event.target || !event.target.hasAttribute('data-image-type-clean')) return;

        const imageInput = document.getElementById(imageTypeModal.clickedButton.dataset.imageTypeField);

        imageInput.value = '';
        document.getElementById(event.target.dataset.imageTypeField + '_text').innerHTML = '';
        var widget = document.getElementById(event.target.dataset.imageTypeWidget);

        var thumbnail = widget.querySelector('[data-image-type-thumbnail]');
        if (thumbnail) {
            thumbnail.innerHTML = '';
        }

        // propagate data version
        for (let key in imageInput.dataset) {
            if (!key.match(/^imageVersion/i)) {
                continue;
            }
            delete imageInput.dataset[key]
        }

        // dispatches image unselected event
        imageInput.dispatchEvent(new Event('sfs_image.unselected', {bubbles: true}));
    });
}