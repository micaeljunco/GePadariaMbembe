# Importa a biblioteca principal do Selenium para abrir e controlar o navegador
from selenium import webdriver

# Importa a classe By, usada para localizar elementos na página (por ID, NAME, XPATH, etc)
from selenium.webdriver.common.by import By

# Importa a classe Select, usada para manipular campos do tipo <select> (dropdown)
from selenium.webdriver.support.ui import Select

# Importa o recurso de espera explícita (espera até que uma condição seja atendida)
from selenium.webdriver.support.ui import WebDriverWait

# Importa condições pré-definidas para WebDriverWait (ex: elemento presente, alerta visível)
from selenium.webdriver.support import expected_conditions as EC

# Biblioteca padrão do Python para adicionar pausas
import time


# Cria uma instância do navegador Chrome
driver = webdriver.Chrome()

# Maximiza a janela do navegador
driver.maximize_window()


# === LOGIN ===
# Abre a página de login do sistema
driver.get("http://localhost:8080/GePadariaMbembe/")

# Preenche e-mail e senha
time.sleep(2)  # Pausa de 2 segundos
# Espera o campo de e-mail estar presente e digita o valor
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email"))).send_keys("admin@gmail.com")
time.sleep(2)  # Pausa de 2 segundos
# Espera o campo de senha estar presente e digita o valor
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "senha"))).send_keys("admin123")
time.sleep(2)  # Pausa de 2 segundos

# Clica no botão "Entrar"
driver.find_element(By.ID, "btn-entrar").click()
time.sleep(1)  # Pausa rápida

# Espera o alerta aparecer (depois do login) e clica em "OK"
WebDriverWait(driver, 10).until(EC.alert_is_present())
alert = driver.switch_to.alert  # Troca o foco para o alerta
alert.accept()  # Confirma o alerta

# Abre a página de itens do sistema
driver.get("http://localhost:8080/GePadariaMbembe/view/itens.php")
time.sleep(3)  # Pausa de 3 segundos para carregar a página


# 1. Clica no botão "Cadastrar Itens"
cadastrar_btn = driver.find_element(By.ID, "abrirCadastroItens")  # Localiza o botão pelo ID
driver.execute_script("arguments[0].click();", cadastrar_btn)  # Executa o clique via JavaScript
time.sleep(2)  # Pausa de 2 segundos


# 2. Preenche o formulário do popup (dialog de cadastro)
driver.find_element(By.NAME, "nomeItem").send_keys("Cacetinho")  # Nome do item
time.sleep(1)

driver.find_element(By.NAME, "quantMin").send_keys("10")  # Quantidade mínima
time.sleep(1)

driver.find_element(By.NAME, "quant").send_keys("50")  # Quantidade em estoque
time.sleep(1)

# Seleciona a categoria no campo dropdown
categoria_select = Select(driver.find_element(By.NAME, "categoria"))
categoria_select.select_by_visible_text("Insumo")  # Escolhe a opção "Insumo"
time.sleep(1)

# Seleciona a unidade de medida no campo dropdown
uni_select = Select(driver.find_element(By.NAME, "unidade_medida"))
uni_select.select_by_visible_text("Kg")  # Escolhe a opção "Kg"
time.sleep(1)

driver.find_element(By.NAME, "validade").send_keys("31-12-2025")  # Data de validade do item
time.sleep(1)

# Seleciona o fornecedor no campo dropdown
fornecedor_select = Select(driver.find_element(By.NAME, "idFornecedor"))
fornecedor_select.select_by_index(0)  # Seleciona o primeiro fornecedor da lista
time.sleep(1)

driver.find_element(By.NAME, "valUni").send_keys("7.50")  # Valor unitário do item
time.sleep(1)


# 3. Clica no botão "Cadastrar" do popup
salvar_btn = driver.find_element(By.XPATH, "//dialog[@id='cadastroItens']//button[contains(text(),'Cadastrar')]")
salvar_btn.click()  # Clica no botão de cadastro
time.sleep(1)

# Espera o alerta aparecer (confirmação do cadastro) e clica em "OK"
WebDriverWait(driver, 10).until(EC.alert_is_present())
alert = driver.switch_to.alert
alert.accept()

# Aguarda alguns segundos para visualizar o resultado
time.sleep(5)

# Fecha o navegador
driver.quit()
