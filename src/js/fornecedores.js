function editarFornecedor(linha) {
  const dialog = document.getElementById("editarFornecedor");
  dialog.showModal();

  // Obtém os campos do formulário
  const campoNome = document.getElementById("nomeFornecedorEd");
  const campoCNPJ = document.getElementById("cnpjFornecedorEd");
  const campoDesc = document.getElementById("descFornecedorEd");
  const campoTel = document.getElementById("telFornecedorEd");
  const campoId = document.getElementById("id_fornecedorEd");

  // Obtém os valores das células da tabela
  const id = linha.children[0].textContent.trim();
  const nome = linha.children[1].textContent.trim();
  const descricao = linha.children[2].textContent.trim();
  const telefone = linha.children[3].textContent.trim();
  const cnpj = linha.children[4].textContent.trim();

  // Preenche os campos do formulário com os valores da tabela
  campoId.value = id;
  campoNome.value = nome;
  campoDesc.value = descricao;
  campoTel.value = telefone;
  campoCNPJ.value = cnpj;
}
