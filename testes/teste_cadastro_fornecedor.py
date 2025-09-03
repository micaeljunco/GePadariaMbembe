from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

driver = webdriver.Chrome()
driver.maximize_window()

try:
    # === LOGIN ===
    time.sleep(2)
    driver.get("http://localhost:8080/GePadariaMbembe/view/index.php")
    time.sleep(2)

    time.sleep(2)
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "email"))
    ).send_keys("admin@gmail.com")
    time.sleep(2)

    time.sleep(2)
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "senha"))
    ).send_keys("admin123")
    time.sleep(2)

    time.sleep(2)
    driver.find_element(By.ID, "btn-entrar").click()
    time.sleep(2)

    # Trata alerta de login (se houver)
    try:
        time.sleep(2)
        WebDriverWait(driver, 5).until(EC.alert_is_present())
        driver.switch_to.alert.accept()
        time.sleep(2)
    except:
        pass  # segue o baile se não houver alerta

    # === NAVEGAR PARA FORNECEDORES ===
    def abrir_fornecedores():
        time.sleep(2)
        driver.get("http://localhost:8080/GePadariaMbembe/view/fornecedores.php")
        time.sleep(2)
        try:
            WebDriverWait(driver, 5).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(.,'Gestão de Fornecedores')]"))
            )
            return
        except:
            time.sleep(2)
            driver.get("http://localhost:8080/GePadariaMbembe/view/fornecedor.php")
            time.sleep(2)
            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(.,'Gestão de Fornecedores')]"))
            )

    abrir_fornecedores()

    # === ABRIR O <dialog> DE CADASTRO ===
    time.sleep(2)
    btn_open = WebDriverWait(driver, 15).until(
        EC.presence_of_element_located((By.XPATH, "//button[contains(normalize-space(),'Cadastrar Fornecedores')]"))
    )
    driver.execute_script("arguments[0].scrollIntoView({block:'center'});", btn_open)
    driver.execute_script("arguments[0].click();", btn_open)
    time.sleep(2)

    # Garante que o dialog ficou visível
    WebDriverWait(driver, 10).until(
        EC.visibility_of_element_located((By.ID, "cadastroFornecedores"))
    )

    # === PREENCHER CAMPOS ===
    time.sleep(2)
    driver.find_element(By.ID, "nomeFornecedor").send_keys("Fornecedor Teste")
    time.sleep(2)
    driver.find_element(By.ID, "cnpjFornecedor").send_keys("33.637.069/0001-80")
    time.sleep(2)
    driver.find_element(By.ID, "descFornecedor").send_keys("Fornecedor de Farinha de Rosca")
    time.sleep(2)
    driver.find_element(By.ID, "telFornecedor").send_keys("(21) 98765-4321")
    time.sleep(2)

    # === ENVIAR FORMULÁRIO ===
    btn_submit = driver.find_element(
        By.XPATH, "//dialog[@id='cadastroFornecedores']//button[@type='submit' or text()='Cadastrar']"
    )
    time.sleep(2)
    driver.execute_script("arguments[0].click();", btn_submit)
    time.sleep(2)

    # Espera o dialog sumir
    WebDriverWait(driver, 10).until(
        EC.invisibility_of_element_located((By.ID, "cadastroFornecedores"))
    )

    # === VALIDAÇÃO SIMPLES: NOME NA TABELA ===
    time.sleep(2)
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//table//td[contains(.,'Fornecedor Teste Selenium')]"))
    )
    time.sleep(2)
    print(" Cadastro confirmado na tabela.")

except Exception as e:
    print(" Erro no teste:", e)
finally:
    time.sleep(2)
    driver.quit()
