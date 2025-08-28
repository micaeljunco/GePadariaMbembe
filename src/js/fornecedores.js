function editarFornecedor(linha) {
    const dialog = document.getElementById("editarFornecedor");
    dialog.showModal();
  
    // Obtem os campos do formulário
    const campoNome = document.getElementById("nomeFornecedorEd");
    const campoCNPJ = document.getElementById("cnpjFornecedorEd");
    const campoDesc = document.getElementById("descFornecedorEd");
    const campoTel = document.getElementById("telFornecedorEd");
    const CampoId_fornecedor = document.getElementById("id_fornecedorEd");
  
    // Passa os valores da tabela para o form
    CampoId_fornecedor.value = linha.children[0].textContent.trim();
    campoNome.value = linha.children[1].textContent.trim();
    campoDesc.value = linha.children[2].textContent.trim();
    campoTel.value = linha.children[3].textContent.trim();
    campoCNPJ.value = linha.children[4].textContent.trim();
    return; 
  }
  