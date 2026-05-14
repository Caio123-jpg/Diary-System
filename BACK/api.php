<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$dataFile = __DIR__ . '/data.json';

/* Função para ler o JSON */
function readData() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        return [];
    }
    $json = file_get_contents($dataFile);
    return json_decode($json, true) ?? [];
}

/* Função para salvar o JSON */
function saveData($data) {
    global $dataFile;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($dataFile, $json, LOCK_EX);
}

/* Obter a ação requisitada */
$action = $_GET['action'] ?? $_POST['action'] ?? null;

try {
    switch ($action) {
        case 'list':
            /* Ler e retornar todos os contatos */
            $contacts = readData();
            echo json_encode([
                'success' => true,
                'data' => $contacts
            ]);
            break;

        case 'create':
            /* Criar novo contato */
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Validação básica
            if (empty($input['name']) || empty($input['phone']) || empty($input['email'])) {
                throw new Exception('Nome, telefone e e-mail são obrigatórios.');
            }

            $contacts = readData();
            
            // Gerar novo ID (maior ID + 1)
            $newId = max(array_column($contacts, 'id')) + 1 ?? 1;
            
            // Criar novo contato
            $newContact = [
                'id' => $newId,
                'name' => trim($input['name']),
                'phone' => trim($input['phone']),
                'email' => trim($input['email'])
            ];
            
            $contacts[] = $newContact;
            saveData($contacts);
            
            echo json_encode([
                'success' => true,
                'message' => 'Contato criado com sucesso!',
                'data' => $newContact
            ]);
            break;

        case 'update':
            // Atualizar contato existente
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (empty($input['id'])) {
                throw new Exception('ID do contato é obrigatório.');
            }
            
            if (empty($input['name']) || empty($input['phone']) || empty($input['email'])) {
                throw new Exception('Nome, telefone e e-mail são obrigatórios.');
            }

            $contacts = readData();
            $found = false;
            
            foreach ($contacts as &$contact) {
                if ($contact['id'] == $input['id']) {
                    $contact['name'] = trim($input['name']);
                    $contact['phone'] = trim($input['phone']);
                    $contact['email'] = trim($input['email']);
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                throw new Exception('Contato não encontrado.');
            }
            
            saveData($contacts);
            
            echo json_encode([
                'success' => true,
                'message' => 'Contato atualizado com sucesso!'
            ]);
            break;

        case 'delete':
            // Deletar contato
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (empty($input['id'])) {
                throw new Exception('ID do contato é obrigatório.');
            }

            $contacts = readData();
            $initialCount = count($contacts);
            
            // Filtrar removendo o contato com o ID
            $contacts = array_filter($contacts, function ($contact) use ($input) {
                return $contact['id'] != $input['id'];
            });
            
            if (count($contacts) === $initialCount) {
                throw new Exception('Contato não encontrado.');
            }
            
            // Reindexar o array
            $contacts = array_values($contacts);
            saveData($contacts);
            
            echo json_encode([
                'success' => true,
                'message' => 'Contato deletado com sucesso!'
            ]);
            break;

        default:
            throw new Exception('Ação inválida.');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>