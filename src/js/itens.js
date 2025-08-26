function editarItem(linha) {
  const dialog = document.getElementById("editarItem");
  dialog.showModal();

  // Obtem os campos do formulário
  const campoNome = document.getElementById("nomeItemEd");
  const campoQuantMin = document.getElementById("quantMinEd");
  const campoQuant = document.getElementById("quantEd");
  const campoCategoria = document.getElementById("categoriaEd");
  const campoValidade = document.getElementById("validadeEd");
  const campoIdFornecedor = document.getElementById("idFornecedorEd");
  const campoValUni = document.getElementById("valUniEd");
  const id_itemCampoEditar = document.getElementById("id_itemCampoEditar");

  // Passa os valores da tabela para o form
  id_itemCampoEditar.value = linha.children[0].textContent.trim();
  campoNome.value = linha.children[1].textContent.trim();
  campoQuantMin.value = linha.children[2].textContent.trim();
  campoQuant.value = linha.children[3].textContent.trim();

  // Para o select, converte o texto da tabela em value correspondente
  const categoriaText = linha.children[4].textContent.trim().toLowerCase();
  campoCategoria.value = categoriaText === "insumo" ? "insumo" : "produto";

  campoValidade.value = linha.children[5].textContent.trim();

  // Para fornecedor, você precisa do ID. Se a tabela só mostra o nome, pode usar dataset no <tr> ou <td>
  // Exemplo simples: armazenar o ID no data-id-fornecedor da linha
  campoIdFornecedor.value = linha.children[6].dataset.idFornecedor || "0";

  // Eu não tenho a minima ideia do porquê isso não funciona :(
  const valUniText = linha.children[7].children[1].textContent.trim();
  campoValUni.value = parseFloat(valUniText);

  return;
}
