const archivosPorPaciente = {};

document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("change", function (e) {
        if (e.target && e.target.classList.contains("file-input")) {
            handleFileInput(e);
        }
    });
});

function bkhandleFileInput(event) {
    const input = event.target;
    const pacienteId = input.getAttribute("data-id");
    const files = input.files;

    if (!archivosPorPaciente[pacienteId]) {
        archivosPorPaciente[pacienteId] = [];
    }

    if (!pacienteId || !files.length) return;

    const swiperWrapper = document.getElementById(`swiperWrapper-${pacienteId}`);
    const pagination = document.getElementById(`swiperPagination-${pacienteId}`);
    const nextBtn = document.getElementById(`swiperNext-${pacienteId}`);
    const prevBtn = document.getElementById(`swiperPrev-${pacienteId}`);

    if (!swiperWrapper) return;

    Array.from(files).forEach((file, index) => {
        const idUnico = `${pacienteId}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
    
        archivosPorPaciente[pacienteId].push({
            id: idUnico,
            file: file,
            name: file.name,
        });

        addDocumentCard(file, swiperWrapper, pacienteId, idUnico);
    });

    // Mostrar controles si hay más de 1 archivo
    if (swiperWrapper.children.length > 1) {
        pagination.classList.remove("d-none");
        nextBtn.classList.remove("d-none");
        prevBtn.classList.remove("d-none");
    }

    initSwiper(pacienteId);
}

function handleFileInput(event) {
    const input = event.target;
    const pacienteId = input.getAttribute("data-id");
    const files = input.files;

    if (!pacienteId || !files.length) return;

    const swiperWrapper = document.getElementById(`swiperWrapper-${pacienteId}`);
    const pagination = document.getElementById(`swiperPagination-${pacienteId}`);
    const nextBtn = document.getElementById(`swiperNext-${pacienteId}`);
    const prevBtn = document.getElementById(`swiperPrev-${pacienteId}`);
    if (!swiperWrapper) return;

    if (!archivosPorPaciente[pacienteId]) {
        archivosPorPaciente[pacienteId] = [];
    }

    let count = 0;
    Array.from(files).forEach((file) => {
        const uniqueId = `${pacienteId}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
        console.log(uniqueId)
        archivosPorPaciente[pacienteId].push({ id: uniqueId, file, name: file.name });

        addDocumentCard(file, swiperWrapper, pacienteId, count, uniqueId);
        count++;
    });

    if (swiperWrapper.children.length > 1) {
        pagination.classList.remove("d-none");
        nextBtn.classList.remove("d-none");
        prevBtn.classList.remove("d-none");
    }

    initSwiper(pacienteId);
}


function addDocumentCard(file, swiperWrapper, pacienteId, index, uniqueId) {
    console.log({uniqueId})
    const fileURL = URL.createObjectURL(file);
    const fileType = file.type;
    const slide = document.createElement("div");

    slide.className = "swiper-slide";
    slide.setAttribute("data-file-index", index); 

    const card = document.createElement("div");
    card.className = "card h-100 document-card";

    const title = document.createElement("div");
    title.className = "card-header border-0";
    title.innerHTML = `<h6 class="text-blue-70 fs-sm line-clamp-1"><span class="file-index"></span>: <b class="text-title-3">${file.name}</b></h6>`;

    const preview = document.createElement("div");
    preview.className = "card-body card-preview py-0";
    if (fileType === "application/pdf") {
        const icon = document.createElement("i");
        icon.className = "bi bi-file-earmark-pdf pdf-icon";
        preview.appendChild(icon);
    } else {
        const img = document.createElement("img");
        img.src = fileURL;
        img.className = "img-fluid";
        img.onload = () => URL.revokeObjectURL(fileURL);
        preview.appendChild(img);
    }

    const viewBtn = document.createElement("button");
    viewBtn.type = "button";
    viewBtn.className = "btn view-btn";
    viewBtn.innerHTML = '<i class="bi bi-search"></i>';
    viewBtn.addEventListener("click", () =>
        showPreview(file, file.name, slide)
    );
    preview.appendChild(viewBtn);

    const actions = document.createElement("div");
    actions.className =
        "card-footer border-0 text-center d-flex justify-content-between";

    const successMessage = document.createElement("div");
    successMessage.className =
        "text-success p-1 fs-sm d-flex align-items-center justify-content-start";
    successMessage.innerHTML =
        '<i class="bi bi-check-circle me-1"></i> Subido con éxito.';

    actions.appendChild(successMessage);

    // const uniqueId = `${pacienteId}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
    slide.setAttribute("data-id-unico", uniqueId);
    console.log(`🧷 Creando setAttribute con ID único: ${uniqueId}`);

    const deleteBtn = document.createElement("button");
    deleteBtn.type = "button";
    deleteBtn.className = "btn delete-btn";
    deleteBtn.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
    deleteBtn.addEventListener("click", () => {
        slide.remove();
        $(`.${uniqueId}`).remove();
        updateDocumentIndexes(swiperWrapper);
        initSwiper(pacienteId);
        setTimeout(function(){
            const swiperWrapper = document.querySelector(`#swiperWrapper-${pacienteId}`);
            const numberOfSlides = swiperWrapper.querySelectorAll('.swiper-slide').length;
            $(`#content-soportes-${pacienteId} .file-list`).each(function(index, element) {
                const $el = $(element);
                
                // Enumerar todos los elementos .fileNumber que existan dentro de este file-list
                $el.find('.fileNumber').each(function(i) {
                    $(this).html(`${i + 1}`);
                });
            });
            const fileInput = $('#file-'+pacienteId)[0]; // 'input' directamente con [0]

            // El índice del archivo a eliminar (por ejemplo, el archivo en el índice 1)
            const indexToRemove = parseInt(slide.getAttribute("data-file-index"));

            // Crea una nueva lista de archivos sin el archivo en el índice 'indexToRemove'
            const newFiles = Array.from(fileInput.files).filter((_, index) => index !== indexToRemove);

            // Asigna los archivos restantes al input file
            const dataTransfer = new DataTransfer();
            newFiles.forEach(file => dataTransfer.items.add(file)); // Agrega los archivos restantes al DataTransfer

            // Actualiza el input file con la nueva lista de archivos
            fileInput.files = dataTransfer.files;
        },250)
    });

    actions.appendChild(deleteBtn);
    card.appendChild(title);
    card.appendChild(preview);
    card.appendChild(actions);
    slide.appendChild(card);
    swiperWrapper.appendChild(slide);

    setTimeout(() => {
        successMessage.remove();
        actions.classList.remove("justify-content-between");
        actions.classList.add("justify-content-center");
    }, 3000);

    updateDocumentIndexes(swiperWrapper);
    console.log(pacienteId)
    addInputCard(pacienteId, file, uniqueId)
}

function sincronizarArchivosPaciente(pacienteId) {
    const slides = document.querySelectorAll(`#swiperWrapper-${pacienteId} .swiper-slide`);

    if (!slides.length || !archivosPorPaciente[pacienteId]) return;

    const idsVisibles = Array.from(slides).map(slide => {
        return slide.getAttribute("data-id-unico") ||
               slide.querySelector(".file-item")?.classList[1] || null;
    }).filter(id => id !== null);

    const archivosActuales = archivosPorPaciente[pacienteId];

    const nuevosArchivos = idsVisibles
        .map(id => archivosActuales.find(a => a.id === id))
        .filter(a => a !== undefined);

    archivosPorPaciente[pacienteId] = nuevosArchivos;

    console.log(`[Sync] Archivos sincronizados para paciente ${pacienteId}:`, nuevosArchivos);
}


function showPreview(file, fileName, slide) {
    const index = Array.from(slide.parentElement.children).reverse().indexOf(slide) + 1;
    const modalTitle = document.getElementById("previewModalTitle");
    const modalBody = document.getElementById("previewModalBody");

    // modalTitle.innerHTML = `<h6 class="text-blue-70 fs-sm line-clamp-1">Archivo ${index}: <b class="text-title-3">${fileName}</b></h6>`;
    modalTitle.innerHTML = `<h6 class="text-blue-70 fs-sm line-clamp-1"><b class="text-title-3">${fileName}</b></h6>`;
    modalBody.innerHTML = "";

    if (file.type === "application/pdf") {
        const embed = document.createElement("embed");
        embed.src = URL.createObjectURL(file);
        embed.type = "application/pdf";
        embed.width = "100%";
        embed.height = "500px";
        modalBody.appendChild(embed);
    } else {
        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.className = "img-fluid";
        modalBody.appendChild(img);
    }

    const previewModal = new bootstrap.Modal(document.getElementById("previewModal"));
    previewModal.show();
}

function updateDocumentIndexes(swiperWrapper) {
    const slides = Array.from(swiperWrapper.querySelectorAll(".swiper-slide"));//.reverse();
    slides.forEach((slide, i) => {
        const index = i + 1;
        const title = slide.querySelector(".card-header h6");
        if (title) {
            const fileName = title.querySelector("b").textContent;
            title.innerHTML = `<h6 class="text-blue-70 fs-sm line-clamp-1">Archivo ${index}: <b class="text-title-3">${fileName}</b></h6>`;
        }
    });
}

function initSwiper(pacienteId) {
    const swiperContainer = document.getElementById(`swiper-${pacienteId}`);
    if (!swiperContainer) return;

    if (swiperContainer.swiper) {
        swiperContainer.swiper.destroy(true, true);
    }

    new Swiper(swiperContainer, {
        loop: false,
        slidesPerView: 1.5,
        spaceBetween: 30,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: `#swiperNext-${pacienteId}`,
            prevEl: `#swiperPrev-${pacienteId}`,
        },
        pagination: {
            el: `#swiperPagination-${pacienteId}`,
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 1.5,
            },
            1024: {
                slidesPerView: 4.5,
            },
            1280: {
                slidesPerView: 5.5,
            },
        },
    });
}
