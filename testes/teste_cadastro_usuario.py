from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# Configuração do webdriver
driver = webdriver.Chrome()
driver.maximize_window()

# === LOGIN ===
driver.get("http://localhost:8080/GePadariaMbembe/view/index.php")

# Preenche e-mail e senha
time.sleep(2)
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email"))).send_keys("admin@gmail.com")
time.sleep(2)
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "senha"))).send_keys("admin123")
time.sleep(2)

# Clica no botão "Entrar"
driver.find_element(By.ID, "btn-entrar").click()
time.sleep(1)

# Espera o alerta aparecer e clica em "OK"
WebDriverWait(driver, 10).until(EC.alert_is_present())
alert = driver.switch_to.alert
alert.accept()

# Abre a página de usuários
driver.get("http://localhost:8080/GePadariaMbembe/view/usuarios.php")
time.sleep(3)

# 1. Clica no botão "Cadastrar Usuários"
cadastrar_btn = driver.find_element(By.XPATH, "//button[contains(text(),'Cadastrar Usuários')]")
cadastrar_btn.click()
time.sleep(3)

# 2. Preenche o formulário do popup

driver.find_element(By.NAME, "nome").send_keys("Mokelinho da Silva")
time.sleep(1)
driver.find_element(By.NAME, "senha").send_keys("senha123")
time.sleep(1)
driver.find_element(By.NAME, "email").send_keys("mokele.teste@example.com")
time.sleep(1)
driver.find_element(By.NAME, "cpf").send_keys("12345678900")
time.sleep(1)

# Seleciona o cargo
cargo_select = Select(driver.find_element(By.NAME, "cargo"))
cargo_select.select_by_visible_text("Administrador")
time.sleep(3)

# 3. Clica no botão "Salvar"
salvar_btn = driver.find_element(By.XPATH, "//button[contains(text(),'Salvar')]")
salvar_btn.click()

# Dá um tempo para o cadastro ser processado
time.sleep(5)

# 4. Verifica se o novo usuário aparece na tabela
tabela = driver.find_element(By.TAG_NAME, "tbody")
linhas = tabela.find_elements(By.TAG_NAME, "tr")

usuario_encontrado = False
for linha in linhas:
    if "Mokelinho da Silva" in linha.text and "mokele.teste@exemplo.com" in linha.text:
        usuario_encontrado = True
        break

if usuario_encontrado:
    print("Teste passou: usuário cadastrado com sucesso!")
else:
    print("Teste falhou: usuário não encontrado na tabela.")

time.sleep(2)

# Espera o alerta aparecer e clica em "OK"
WebDriverWait(driver, 10).until(EC.alert_is_present())
alert = driver.switch_to.alert
alert.accept()


# Fecha o navegador
time.sleep(5)
driver.quit()
