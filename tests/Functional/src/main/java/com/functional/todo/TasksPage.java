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
    private final By tasksList = By.cssSelector("#tasksList");
    private final By tasksLink = By.cssSelector("#tasksList > li a[href]:first-child");
    private final By markTasksAsDoneLink = By.cssSelector("#tasksList > li a[href]:nth-of-type(2)");
    private final By tasksParagraph = By.cssSelector("#tasksList > li > p:first-of-type");

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

    public WebElement getRemoveTasksButton(int index) {
        return driver.findElements(tasksLink).get(index);
    }

    public WebElement getMarkTasksAsDoneButton(int index) {
        return driver.findElements(markTasksAsDoneLink).get(index);
    }

    public WebElement getTasksParagraph(int index) {
        return driver.findElements(tasksParagraph).get(index);
    }

    public void createTask(String taskName) {
        var input = getTaskNameInput();
        var btn = getSubmitButton();
        input.sendKeys(taskName);
        btn.click();
    }
}
