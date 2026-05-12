# Diary-System
A contact scheduling system.

# Sistema de Agendamento de Contatos
- Exemplo: Uma empresa que precisa cadastrar informações dos seus funcionários, se cria um "contâiner" somente para essas informações. 

- Insere Dados;
- Consulta Dados;
- Atualiza Dados;
- Deleta Dados;


# Ajax e Index
- O Index é a entrada, o Ajax a ponte dos dados para a API.

A. Portal de Entrada (index.php). A "Landing Page" deve listar os dados da agenda que serão: id,
nome, telefone e e-mail. Além de ter os dados do formulário para gravar os dados. (0,25)
B. Módulo CRUD (api.php)
A codificação onde será gravado os dados. (0,50)
• Esse código será o responsável por selecionar, atualizar, excluir e incluir as informações não
tem visualização por parte de usuário.
C. Módulo do Ajax (ajax.js)
Onde os dados são enviados e recebidos. (0,25).
• É o arquivo responsável por receber os dados do index.

Forma de salvar os dados:
- Arquivo JSON.