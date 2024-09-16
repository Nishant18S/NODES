document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('logout-btn');
    const uploadBtn = document.querySelector('.upload-btn');
    const zipFileInput = document.getElementById('zip-file');
    const sheetFileInput = document.getElementById('sheet-file');
    const classSelect = document.getElementById('class-select');
    const subjectSelect = document.getElementById('subject-select');
    const filesList = document.querySelector('.files-list');
    const sortOrder = {
        date: true,
        name: true,
        fileName: true
    };

    // Handle logout
    logoutBtn.addEventListener('click', () => {
        window.location.href = 'logout.php';
    });

    // Load existing files from database and display them
    loadFilesFromDatabase();

    // Handle file uploads
    uploadBtn.addEventListener('click', () => {
        const filesToUpload = [
            ...zipFileInput.files,
            ...sheetFileInput.files
        ];

        const selectedClass = classSelect.value;
        const selectedSubject = subjectSelect.value;

        if (filesToUpload.length === 0) {
            alert("Please select a file to upload.");
            return;
        }

        Array.from(filesToUpload).forEach(file => {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('user', loggedInUser);
            formData.append('class', selectedClass);
            formData.append('subject', selectedSubject);

            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    addFileToList(file, selectedClass, selectedSubject);
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        zipFileInput.value = '';
        sheetFileInput.value = '';
    });

    // Load files from database
    function loadFilesFromDatabase() {
        fetch('get_files.php')
            .then(response => response.json())
            .then(files => {
                filesList.innerHTML = '';
                files.forEach(fileData => addFileItemToUI(fileData));
            })
            .catch(error => console.error('Error:', error));
    }

    // Add file to list
    function addFileToList(file, fileClass, fileSubject) {
        const fileItem = document.createElement('li');
        fileItem.classList.add('file-item');

        const fileDate = new Date().toLocaleString('en-GB');
        const fileName = loggedInUser;
        const fileZip = file.name;

        fileItem.innerHTML = `
            <span class="file-date">${fileDate}</span>
            <span class="file-name">${fileName}</span>
            <span class="file-zip">${fileZip}</span>
            <span class="file-class">${fileClass}</span>
            <span class="file-subject">${fileSubject}</span>
            <button class="remove-btn">REMOVE ❌</button>
        `;

        fileItem.querySelector('.remove-btn').addEventListener('click', () => {
            filesList.removeChild(fileItem);
            removeFromDatabase(fileZip);
        });

        filesList.prepend(fileItem);
    }

    // Remove file from database
    function removeFromDatabase(fileName) {
        const formData = new FormData();
        formData.append('fileName', fileName);

        fetch('delete_file.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                loadFilesFromDatabase();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Sorting functionality
    document.getElementById('filter-date').addEventListener('click', () => {
        sortList('file-date', 'date');
    });

    document.getElementById('filter-name').addEventListener('click', () => {
        sortList('file-name', 'name');
    });

    document.getElementById('filter-file-id').addEventListener('click', () => {
        sortList('file-zip', 'fileName');
    });

    function sortList(className, sortKey) {
        const itemsArray = Array.from(document.querySelectorAll('.file-item'));

        itemsArray.sort((a, b) => {
            const aText = a.querySelector(`.${className}`).textContent;
            const bText = b.querySelector(`.${className}`).textContent;

            if (sortKey === 'date') {
                return sortOrder[sortKey]
                    ? new Date(aText) - new Date(bText)
                    : new Date(bText) - new Date(aText);
            } else {
                return sortOrder[sortKey]
                    ? aText.localeCompare(bText)
                    : bText.localeCompare(aText);
            }
        });

        sortOrder[sortKey] = !sortOrder[sortKey];

        filesList.innerHTML = '';
        itemsArray.forEach(item => filesList.appendChild(item));
    }
});
