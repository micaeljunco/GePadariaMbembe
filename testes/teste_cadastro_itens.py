from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

driver = webdriver.Chrome()
driver.maximize_window()

# Abre a página de itens
driver.get("http://localhost:8080/GePadariaMbembe/view/itens.php")
time.sleep(3)

# 1. Clica no botão "Cadastrar Itens"
cadastrar_btn = driver.find_element(By.ID, "abrirCadastroItens")
driver.execute_script("arguments[0].click();", cadastrar_btn)
time.sleep(2)

# 2. Preenche o formulário do popup
driver.find_element(By.NAME, "nomeItem").send_keys("Cacetinho")
time.sleep(1)

driver.find_element(By.NAME, "quantMin").send_keys("10")
time.sleep(1)

driver.find_element(By.NAME, "quant").send_keys("50")
time.sleep(1)

driver.find_element(By.NAME, "validade").send_keys("31-12-2025")
time.sleep(1)

# Fornecedor (select)
fornecedor_select = Select(driver.find_element(By.NAME, "idFornecedor"))
fornecedor_select.select_by_index(0)  # Ajuste conforme as opções do select
time.sleep(1)

driver.find_element(By.NAME, "valUni").send_keys("7.50")
time.sleep(1)

# Categoria (select)
categoria_select = Select(driver.find_element(By.NAME, "categoria"))
categoria_select.select_by_visible_text("insumo")
time.sleep(1)

# Unidade de Medida (select)
uni_select = Select(driver.find_element(By.NAME, "unidade_medida"))
uni_select.select_by_visible_text("Kg")
time.sleep(1)

# 3. Clica no botão "Cadastrar" do popup
salvar_btn = driver.find_element(By.XPATH, "//dialog[@id='cadastroItens']//button[contains(text(),'Cadastrar')]")
salvar_btn.click()

time.sleep(5)
driver.quit()
