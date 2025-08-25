from selenium import webdriver
from selenium.webdriver.common.by import By
import time

driver = webdriver.Chrome()

driver.get("file:///C:/Users/lucas_sarmento/xampp/htdocs/GePadariaMbembe/view/index.php")


#preenche o campo Nome
nome_input = driver.find_element(By.ID, "name")
nome_input.send_keys("João da Silva")
time.sleep(1)