package com.functional.todo;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

import java.util.List;

public class TasksPage {
    private final WebDriver driver;
    // new tasks form
    private final By newTaskForm = By.cssSelector("#newTaskForm");
    private final By taskNameInput = By.name("taskName");
    private final By submitButton = By.cssSelector("#submitButton");

    // tasks list
    private final By tasksList = By.className("tasksList");
    private final By tasksLink = By.cssSelector("#tasksList > li a[href]:first-child");
    private final By removeTasksButtons = By.cssSelector("#tasksList > li a[href]:first-of-type");


    public TasksPage(WebDriver driver) {
        this.driver = driver;
    }

    public WebElement getNewTasksForm() {
        return driver.findElement(newTaskForm);
    }

    public WebElement getTaskNameInput() {
        return driver.findElement(taskNameInput);
    }

    public WebElement getSubmitButton() {
        return driver.findElement(submitButton);
    }

    public WebElement getTasksList() {
        return driver.findElement(tasksList);
    }

    public List<WebElement> getTasksLinks() {
        return driver.findElements(tasksLink);
    }

    public List<WebElement> getRemoveTasksButtons() {
        return driver.findElements(removeTasksButtons);
    }

    public void createTask(String taskName) {
        var input = getTaskNameInput();
        var btn = getSubmitButton();
        input.sendKeys(taskName);
        btn.click();
    }
}
