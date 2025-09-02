from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

driver = webdriver.Chrome()
driver.maximize_window()

# === LOGIN ===
time.sleep(2)
driver.get("http://localhost:8080/GePadariaMbembe/view/index.php")
time.sleep(2)

# Preenche e-mail e senha
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email"))).send_keys("lucas.magalhaes.lms@gmail.com")
time.sleep(2)
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "senha"))).send_keys("12345678")
time.sleep(2)

# Clica no botão "Entrar"
driver.find_element(By.ID, "btn-entrar").click()

# Espera o alerta aparecer e clica em "OK"
WebDriverWait(driver, 10).until(EC.alert_is_present())
alert = driver.switch_to.alert
alert.accept()

# Abre a página de fornecedores
driver.get("http://localhost:8080/GePadariaMbembe/view/fornecedores.php")
time.sleep(2)

# 1. Clica no botão "Cadastrar Fornecedores"
time.sleep(2)
cadastrar_btn = driver.find_element(By.ID, "cadastrafunc")
driver.execute_script("arguments[0].click();", cadastrar_btn)
time.sleep(1)

# 2. Preenche o formulário do popup
time.sleep(2)
driver.find_element(By.NAME, "nomeFornecedor").send_keys("Padaria do Chef")
time.sleep(2)
driver.find_element(By.NAME, "cnpjFornecedor").send_keys("12.345.678/0001-99")
time.sleep(2)
driver.find_element(By.NAME, "descFornecedor").send_keys("Fornecedor de pães artesanais e ingredientes premium")
time.sleep(2)
driver.find_element(By.NAME, "telefone").send_keys("(21) 98765-4321")
time.sleep(2)

# 3. Clica no botão "Cadastrar" do popup
salvar_btn = driver.find_element(By.XPATH, "//dialog[@id='cadastroFornecedores']//button[contains(text(),'Cadastrar')]")
salvar_btn.click()

time.sleep(5)
driver.quit()
