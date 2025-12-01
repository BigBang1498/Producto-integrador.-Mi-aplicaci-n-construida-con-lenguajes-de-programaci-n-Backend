const API_BASE = 'php';
let currentUser = 'user1';

document.getElementById('userSelect').addEventListener('change', e => {
  currentUser = e.target.value;
  loadGallery();
  toggleAdminPanel();
});

function toggleAdminPanel() {
  const panel = document.getElementById('adminPanel');
  panel.style.display = (currentUser === 'admin') ? 'block' : 'none';
}

async function loadGallery() {
  const res = await fetch(`${API_BASE}/list.php?user=${currentUser}`);
  const data = await res.json();
  const gallery = document.getElementById('gallery');
  gallery.innerHTML = '';
  data.forEach((img, i) => {
    const div = document.createElement('div');
    div.innerHTML = `
      <img src="galleries/${currentUser}/${img.file}" width="150"><br>
      ${img.name}
      <button onclick="deleteImage(${i})">Eliminar</button>
    `;
    gallery.appendChild(div);
  });
}

async function deleteImage(id) {
  const formData = new FormData();
  formData.append('user', currentUser);
  formData.append('id', id);
  const res = await fetch(`${API_BASE}/delete.php`, { method: 'POST', body: formData });
  const text = await res.text();
  alert(text);
  loadGallery();
}

document.getElementById('uploadForm').addEventListener('submit', async e => {
  e.preventDefault();
  const file = document.getElementById('fileInput').files[0];
  if (!file) {
    alert("Selecciona un archivo primero");
    return;
  }
  const formData = new FormData();
  formData.append('user', currentUser);
  formData.append('file', file);
  const res = await fetch(`${API_BASE}/upload.php`, { method: 'POST', body: formData });
  const text = await res.text();
  alert(text);
  loadGallery();
});

async function deleteUser(user) {
  const formData = new FormData();
  formData.append('user', user);
  const res = await fetch(`${API_BASE}/admin_delete_user.php`, { method: 'POST', body: formData });
  const text = await res.text();
  alert(text);
}
loadGallery();
toggleAdminPanel();
