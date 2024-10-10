from selenium import webdriver
from selenium.webdriver.common.by import By
import time

# Set up the WebDriver (Make sure you have the correct driver installed)
driver = webdriver.Chrome()

# Function to take a screenshot before clicking a submit button
def take_screenshot(driver, step_name):
    screenshot_path = f"screenshot_{step_name}.png"
    driver.save_screenshot(screenshot_path)

# Step 1: Open index.html
driver.get("http://localhost:3000/index.html")  # Update with the actual file path

# Step 2: Select 'Teacher' and click on the sign-up button
teacher_div = driver.find_element(By.XPATH, "//h2[contains(text(),'Teacher')]/ancestor::div[@class='card']")
teacher_div.click()
time.sleep(2)

signup_button = driver.find_element(By.XPATH, "//button[contains(text(),'Sign Up')]")
signup_button.click()
time.sleep(2)

# Step 3: Fill in the sign-up details
driver.find_element(By.NAME, 'username').send_keys('test_teacher')
driver.find_element(By.NAME, 'email').send_keys('test_teacher@example.com')
driver.find_element(By.NAME, 'password').send_keys('password123')
signup_submit_button = driver.find_element(By.XPATH, "//button[@type='submit']")

# Take a screenshot before submitting sign-up form
take_screenshot(driver, "signup_form")

# Wait 10 seconds before clicking the submit button
time.sleep(10)
signup_submit_button.click()

# Wait 10 seconds after clicking the submit button
time.sleep(10)

# Step 5: Go to add_student.html from the nav bar
add_student_link = driver.find_element(By.XPATH, "//a[contains(text(),'Add a Student')]")
add_student_link.click()
time.sleep(2)

# Step 6: Add dummy students in add_student.html
driver.find_element(By.NAME, 'student-name').send_keys('John Doe')
driver.find_element(By.NAME, 'student-division').send_keys('A')
driver.find_element(By.NAME, 'student-rollno').send_keys('101')
add_student_button = driver.find_element(By.XPATH, "//button[@type='submit']")

# Take a screenshot before submitting the student form
take_screenshot(driver, "add_student_john_doe")

# Wait 10 seconds before clicking the submit button
time.sleep(10)
add_student_button.click()

# Wait 10 seconds after clicking the submit button
time.sleep(10)

# Add another student
driver.find_element(By.NAME, 'student-name').send_keys('Jane Smith')
driver.find_element(By.NAME, 'student-division').send_keys('A')
driver.find_element(By.NAME, 'student-rollno').send_keys('102')
add_student_button = driver.find_element(By.XPATH, "//button[@type='submit']")

# Take a screenshot before submitting the second student form
take_screenshot(driver, "add_student_jane_smith")

# Wait 10 seconds before clicking the submit button
time.sleep(10)
add_student_button.click()

# Wait 10 seconds after clicking the submit button
time.sleep(10)

# Step 7: Go to give_marks.html from the nav bar
give_marks_link = driver.find_element(By.XPATH, "//a[contains(text(),'Give Marks')]")
give_marks_link.click()
time.sleep(2)

# Step 8: Enter division and subject, then submit the form
driver.find_element(By.NAME, 'division').send_keys('A')
driver.find_element(By.NAME, 'subject').send_keys('Mathematics')
check_roll_numbers_button = driver.find_element(By.XPATH, "//button[@type='submit']")

# Take a screenshot before submitting the check roll numbers form
take_screenshot(driver, "give_marks_division")

# Wait 10 seconds before clicking the submit button
time.sleep(10)
check_roll_numbers_button.click()

# Wait 10 seconds after clicking the submit button
time.sleep(10)

# Enter marks for each student
marks_field_101 = driver.find_element(By.NAME, 'marks_101')
marks_field_101.send_keys('85')

marks_field_102 = driver.find_element(By.NAME, 'marks_102')
marks_field_102.send_keys('90')

# Submit the marks
submit_marks_button = driver.find_element(By.XPATH, "//button[contains(text(),'Submit Marks')]")

# Take a screenshot before submitting the marks form
take_screenshot(driver, "submit_marks")

# Wait 10 seconds before clicking the submit button
time.sleep(10)
submit_marks_button.click()

# Wait 10 seconds after clicking the submit button
time.sleep(10)

# Step 9: Navigate to login.html and login with the same credentials
driver.get("http://localhost:3000/login.html")
time.sleep(2)

driver.find_element(By.NAME, 'username').send_keys('test_teacher')
driver.find_element(By.NAME, 'password').send_keys('password123')

login_button = driver.find_element(By.XPATH, "//button[@type='submit']")

# Take a screenshot before submitting the login form
take_screenshot(driver, "login_form")

# Wait 10 seconds before clicking the submit button
time.sleep(10)
login_button.click()

# Wait 10 seconds after clicking the submit button
time.sleep(10)

# Closing the browser
driver.quit()
