<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(rgba(18, 18, 18, 0.75), rgba(18, 18, 18, 0.75)),
                url('../img/abstract.png')
                no-repeat center center / cover;
            color: #f8f9fa;
        }
        .card {
            background: rgba(31, 31, 31, 0.92);
            border: 1px solid #2f2f2f;
        }
        h1, h2, .form-label, .table th, .badge-soft {
            color: #ffffff;
        }
        
        .form-control, .table {
            background: #161616;
            color: #f8f9fa;
            border-color: #2f2f2f;
        }
        .form-control::placeholder {
            color: rgba(248, 249, 250, 0.7);
        }
        .form-control:focus {
            background: #161616;
            color: #f8f9fa;
            border-color: #5e72e4;
            box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
        }
        .btn-primary {
            background: #5e72e4;
            border-color: #5e72e4;
        }
        .btn-primary:hover {
            background: #4b5ad2;
            border-color: #4b5ad2;
        }
        .badge-soft {
            background: rgba(94, 114, 228, 0.15);
            color: #d7d7ff;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
                            <div>
                                <h1 class="text-white">Agenda de Contatos</h1>
                            </div>
                        </div>

                        <form id="contactForm" class="mb-4">
                            <input type="hidden" id="contactId" value="">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" id="name" class="form-control" placeholder="Nome completo" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="phone" class="form-label">Telefone</label>
                                    <input type="tel" id="phone" class="form-control" placeholder="(99) 99999-9999" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" id="email" class="form-control" placeholder="email@exemplo.com" required>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Salvar contato</button>
                                <button type="button" id="cancelEdit" class="btn btn-danger">Cancelar</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-dark table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Telefone</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col" class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="contactsTable">
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary py-4">Nenhum contato cadastrado ainda.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoYz1EP1ZQnNQFfD3z6V8Bsjq5JmN6CurYfvoEH3Sl0sibVc"
        crossorigin="anonymous"></script>
    <script src="js/ajax.js"></script>
</body>
</html>