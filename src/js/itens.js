function editarItem(linha) {
  const dialog = document.getElementById("editarItem");
  dialog.showModal();

  // Obtem os campos do formulário
  const campoNome = document.getElementById("nomeItemEd");
  const campoQuantMin = document.getElementById("quantMinEd");
  const campoQuant = document.getElementById("quantEd");
  const campoCategoria = document.getElementById("categoriaEd");
  const campoUniMed = document.getElementById("unidade_medidaEd");
  const campoValidade = document.getElementById("validadeEd");
  const campoIdFornecedor = document.getElementById("idFornecedorEd");
  const campoValUni = document.getElementById("valUniEd");
  const id_itemCampoEditar = document.getElementById("id_itemCampoEditar");

  // Passa os valores da tabela para o form
  id_itemCampoEditar.value = linha.children[0].textContent.trim();
  campoNome.value = linha.children[1].textContent.trim();

  // substitui vírgula por ponto
  campoQuantMin.value = linha.children[2].textContent.trim().replace(",", ".");
  campoQuant.value = linha.children[3].textContent.trim().replace(",", ".");

  // Para o select, converte o texto da tabela em value correspondente
  const categoriaText = linha.children[4].textContent.trim().toLowerCase();
  campoCategoria.value = categoriaText === "insumo" ? "insumo" : "produto";
  campoUniMed.value = linha.children[5].textContent.trim();
  campoValidade.value = linha.children[6].textContent.trim();

  // fornecedor
  campoIdFornecedor.value = linha.children[7].dataset.idFornecedor || "0";

  // valor unitário (também troca vírgula por ponto antes do parseFloat)
  const valUniText = linha.children[8].children[1].textContent.trim().replace(",", ".");
  campoValUni.value = parseFloat(valUniText);

  return;
}
