const API_URL = '../BACK/api.php';

// ============================================
// CARREGAR CONTATOS QUANDO A PÁGINA CARREGA
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    loadContacts();
    setupFormListener();
    setupCancelButton();
});

// ============================================
// CARREGAR E EXIBIR CONTATOS
// ============================================
function loadContacts() {
    fetch(`${API_URL}?action=list`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                displayContacts(result.data);
            } else {
                console.error('Erro ao carregar contatos:', result.error);
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
}

// ============================================
// EXIBIR CONTATOS NA TABELA
// ============================================
function displayContacts(contacts) {
    const tbody = document.getElementById('contactsTable');
    
    // Se não há contatos, mostrar mensagem
    if (contacts.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-secondary py-4">Nenhum contato cadastrado ainda.</td></tr>';
        return;
    }

    // Limpar tabela
    tbody.innerHTML = '';

    // Adicionar cada contato à tabela
    contacts.forEach(contact => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${contact.id}</td>
            <td>${contact.name}</td>
            <td>${contact.phone}</td>
            <td>${contact.email}</td>
            <td class="text-end">
                <button class="btn btn-sm btn-warning me-2" onclick="editContact(${contact.id})">
                    Editar
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteContact(${contact.id})">
                    Deletar
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// ============================================
// LISTENER DO FORMULÁRIO
// ============================================
function setupFormListener() {
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        const contactId = document.getElementById('contactId').value;
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();

        if (contactId) {
            // Modo EDIÇÃO
            updateContact(contactId, name, phone, email);
        } else {
            // Modo CRIAÇÃO
            createContact(name, phone, email);
        }
    });
}

// ============================================
// CRIAR NOVO CONTATO
// ============================================
function createContact(name, phone, email) {
    const data = { name, phone, email };

    fetch(API_URL + '?action=create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Contato criado com sucesso!');
                clearForm();
                loadContacts(); // Recarregar tabela
            } else {
                alert('Erro: ' + result.error);
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
}

// ============================================
// EDITAR CONTATO
// ============================================
function editContact(id) {
    // Fazer requisição para obter os dados do contato
    fetch(`${API_URL}?action=list`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const contact = result.data.find(c => c.id == id);
                if (contact) {
                    // Preencher formulário com os dados
                    document.getElementById('contactId').value = contact.id;
                    document.getElementById('name').value = contact.name;
                    document.getElementById('phone').value = contact.phone;
                    document.getElementById('email').value = contact.email;
                    
                    // Scroll para o formulário
                    document.getElementById('contactForm').scrollIntoView({ behavior: 'smooth' });
                    
                    // Mudar texto do botão
                    const submitBtn = document.querySelector('#contactForm button[type="submit"]');
                    submitBtn.textContent = 'Atualizar contato';
                }
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
}

// ============================================
// ATUALIZAR CONTATO
// ============================================
function updateContact(id, name, phone, email) {
    const data = { id, name, phone, email };

    fetch(API_URL + '?action=update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Contato atualizado com sucesso!');
                clearForm();
                loadContacts(); // Recarregar tabela
            } else {
                alert('Erro: ' + result.error);
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
}

// ============================================
// DELETAR CONTATO
// ============================================
function deleteContact(id) {
    if (!confirm('Tem certeza que deseja deletar este contato?')) {
        return;
    }

    const data = { id };

    fetch(API_URL + '?action=delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Contato deletado com sucesso!');
                loadContacts(); // Recarregar tabela
            } else {
                alert('Erro: ' + result.error);
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
}

// ============================================
// LIMPAR FORMULÁRIO
// ============================================
function clearForm() {
    document.getElementById('contactForm').reset();
    document.getElementById('contactId').value = '';
    
    // Resetar texto do botão
    const submitBtn = document.querySelector('#contactForm button[type="submit"]');
    submitBtn.textContent = 'Salvar contato';
}

// ============================================
// BOTÃO CANCELAR
// ============================================
function setupCancelButton() {
    const cancelBtn = document.getElementById('cancelEdit');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', clearForm);
    }
}
