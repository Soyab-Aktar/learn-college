# OpenGL/FreeGLUT Complete Guide for Exams

## Table of Contents
1. [FreeGLUT Initialization Functions](#freeglut-initialization)
2. [Display and Rendering](#display-and-rendering)
3. [Coordinate Systems & Transformations](#coordinate-systems)
4. [Drawing Primitives](#drawing-primitives)
5. [Practical Examples](#practical-examples)
6. [Common Exam Patterns](#common-exam-patterns)

---

## FreeGLUT Initialization Functions

### 1. **glutInit()**

**What it does:** Initializes the GLUT library and processes command-line arguments

**Why use it:** Must be called before any other GLUT function. Prepares the environment for windowing operations.

**When to use:** Always first in main()

**Syntax:**
```cpp
glutInit(&argc, argv);
```

**Example:**
```cpp
int main(int argc, char** argv) {
    glutInit(&argc, argv);  // Must be first
    // ... rest of initialization
}
```

---

### 2. **glutInitDisplayMode()**

**What it does:** Sets the display mode for the window (buffering and color models)

**Why use it:** Determines how graphics are rendered (single/double buffer, RGB/indexed color)

**When to use:** After glutInit(), before creating the window

**Common Flags:**
```
GLUT_SINGLE   : Single buffer (faster, but flickers)
GLUT_DOUBLE   : Double buffer (smoother, used for animation)
GLUT_RGB      : RGB color mode (standard)
GLUT_RGBA     : RGB + Alpha (for transparency)
GLUT_DEPTH    : Depth buffer (for 3D graphics)
```

**Syntax:**
```cpp
glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
```

**Examples:**
```cpp
// For 2D graphics (exams)
glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);

// For smooth animation (3D)
glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGB | GLUT_DEPTH);
```

---

### 3. **glutInitWindowSize()**

**What it does:** Sets the initial window dimensions in pixels

**Why use it:** Defines the canvas size for drawing

**When to use:** After glutInitDisplayMode()

**Syntax:**
```cpp
glutInitWindowSize(width, height);
```

**Example:**
```cpp
glutInitWindowSize(500, 500);  // Creates 500x500 pixel window
```

**Important Note:** The window size should match your gluOrtho2D() coordinates for easy mapping.

---

### 4. **glutInitWindowPosition()**

**What it does:** Sets where the window appears on your screen

**Why use it:** Control initial window placement (optional)

**When to use:** Before glutCreateWindow() (optional step)

**Syntax:**
```cpp
glutInitWindowPosition(x, y);  // x, y in screen pixels from top-left
```

**Example:**
```cpp
glutInitWindowPosition(100, 100);  // Window appears at (100, 100) on screen
```

---

### 5. **glutCreateWindow()**

**What it does:** Creates the actual window with the specified configurations

**Why use it:** Without this, no window is created

**When to use:** After all glutInit* functions

**Syntax:**
```cpp
glutCreateWindow("Window Title");
```

**Returns:** Window ID (integer)

**Example:**
```cpp
int windowID = glutCreateWindow("My Graphics Window");
```

---

## Display and Rendering

### 6. **glutDisplayFunc()**

**What it does:** Registers the callback function that handles all drawing

**Why use it:** Tells GLUT which function contains your drawing code

**When to use:** After glutCreateWindow()

**Syntax:**
```cpp
glutDisplayFunc(displayFunctionName);
```

**Example:**
```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    // Draw your graphics here
    glFlush();
}

int main(int argc, char** argv) {
    // ... initialization ...
    glutDisplayFunc(display);  // Register the display callback
}
```

**Important:** The display function is called automatically by GLUT when:
- Window is created
- Window is resized
- Window is exposed (uncovered)
- glutPostRedisplay() is called

---

### 7. **glutMainLoop()**

**What it does:** Enters infinite loop that processes events and calls callbacks

**Why use it:** Keeps the program running and responsive

**When to use:** Always last before return 0

**Syntax:**
```cpp
glutMainLoop();
```

**Important Note:** This function never returns (blocks forever until window closes)

---

### 8. **glFlush()**

**What it does:** Forces OpenGL to execute all pending commands and display results

**Why use it:** Ensures drawing is visible immediately

**When to use:** End of display() function for GLUT_SINGLE, or after drawing operations

**Syntax:**
```cpp
glFlush();
```

**Example:**
```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    glBegin(GL_POINTS);
        glVertex2i(250, 250);
    glEnd();
    glFlush();  // Make drawing visible
}
```

---

### 9. **glutSwapBuffers()**

**What it does:** Swaps front and back buffers (for double buffering)

**Why use it:** Prevents flickering when using GLUT_DOUBLE mode

**When to use:** At end of display() when using double buffering

**Syntax:**
```cpp
glutSwapBuffers();
```

**Example:**
```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    // ... drawing code ...
    glutSwapBuffers();  // Only if using GLUT_DOUBLE
}
```

**Single vs Double Buffer:**
```cpp
// SINGLE BUFFER (simple, flickering)
glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
// In display(): glFlush();

// DOUBLE BUFFER (smooth, no flicker)
glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGB);
// In display(): glutSwapBuffers();
```

---

## Coordinate Systems & Transformations

### 10. **glMatrixMode()**

**What it does:** Selects which transformation matrix to modify

**Why use it:** Different matrices for different purposes

**When to use:** Before transformation operations

**Common Modes:**
```cpp
GL_PROJECTION   : For viewing transformation (2D/3D)
GL_MODELVIEW    : For object transformations (rotation, scale, translate)
```

**Syntax:**
```cpp
glMatrixMode(GL_PROJECTION);
```

**Example:**
```cpp
void init() {
    glMatrixMode(GL_PROJECTION);  // Select projection matrix
    glLoadIdentity();
    gluOrtho2D(0.0, 500.0, 0.0, 500.0);  // Set 2D coordinate system
}
```

---

### 11. **glLoadIdentity()**

**What it does:** Resets the current matrix to identity (no transformations)

**Why use it:** Start fresh before applying new transformations

**When to use:** Before each matrix setup

**Syntax:**
```cpp
glLoadIdentity();
```

**Example:**
```cpp
void init() {
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();  // Reset to default
    gluOrtho2D(0.0, 500.0, 0.0, 500.0);
}
```

---

### 12. **gluOrtho2D()** (Orthographic 2D Projection)

**What it does:** Sets up 2D coordinate system mapping

**Why use it:** Maps logical coordinates to screen coordinates

**When to use:** In init() for 2D graphics

**Syntax:**
```cpp
gluOrtho2D(left, right, bottom, top);
```

**Parameters:**
- `left, right`: X-axis range
- `bottom, top`: Y-axis range

**Example:**
```cpp
void init() {
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluOrtho2D(0.0, 500.0, 0.0, 500.0);  // Coordinate system: (0,0) to (500,500)
}
```

**Important:** Origin (0,0) is at BOTTOM-LEFT, not top-left!

**Coordinate System Visualization:**
```
(0,500) -------- (500,500)   <- Top
  |                  |
  |   Drawing Area   |
  |                  |
(0,0) ---------- (500,0)     <- Bottom
```

---

## Drawing Primitives

### 13. **glBegin() and glEnd()**

**What it does:** Starts and ends a sequence of vertices

**Why use it:** Groups vertices for a specific drawing primitive

**When to use:** Always wrap vertex definitions

**Syntax:**
```cpp
glBegin(PRIMITIVE_TYPE);
    // Define vertices here
    glVertex2i(x, y);
    glVertex2i(x, y);
    // ...
glEnd();
```

**Primitive Types:**
```cpp
GL_POINTS       : Individual points
GL_LINES        : Connected line pairs
GL_LINE_STRIP   : Connected line sequence
GL_LINE_LOOP    : Connected line sequence (closed)
GL_TRIANGLES    : Groups of 3 vertices form triangles
GL_QUADS        : Groups of 4 vertices form quadrilaterals
GL_POLYGON      : Draw any polygon
```

---

### 14. **glVertex2i() and glVertex2f()**

**What it does:** Defines a point in 2D space

**Why use it:** Specifies coordinates for shapes

**When to use:** Inside glBegin()/glEnd() blocks

**Syntax:**
```cpp
glVertex2i(x, y);   // Integer coordinates
glVertex2f(x, y);   // Float coordinates
```

**Example:**
```cpp
glBegin(GL_POINTS);
    glVertex2i(100, 150);
    glVertex2i(200, 250);
glEnd();
```

---

### 15. **glColor3f() and glColor3ub()**

**What it does:** Sets the drawing color

**Why use it:** Controls color of subsequent drawings

**When to use:** Before drawing commands

**Syntax:**
```cpp
glColor3f(red, green, blue);    // Range: 0.0 to 1.0
glColor3ub(red, green, blue);   // Range: 0 to 255
```

**Examples:**
```cpp
glColor3f(1.0, 1.0, 1.0);       // White (float)
glColor3f(1.0, 0.0, 0.0);       // Red
glColor3f(0.0, 1.0, 0.0);       // Green
glColor3f(0.0, 0.0, 1.0);       // Blue
glColor3ub(255, 128, 0);        // Orange (using ubyte)
```

**Color Mixing:**
```
Red   = (1, 0, 0)
Green = (0, 1, 0)
Blue  = (0, 0, 1)
White = (1, 1, 1)
Black = (0, 0, 0)
Yellow = (1, 1, 0)  <- Red + Green
Cyan   = (0, 1, 1)  <- Green + Blue
```

---

### 16. **glClear()**

**What it does:** Clears the buffer to the set background color

**Why use it:** Removes previous drawing, preventing trails

**When to use:** Beginning of display() function

**Syntax:**
```cpp
glClear(GL_COLOR_BUFFER_BIT);
```

**Other Clear Buffers:**
```cpp
GL_COLOR_BUFFER_BIT    : Clear color
GL_DEPTH_BUFFER_BIT    : Clear depth (for 3D)
```

**Example:**
```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);  // Clear to background color
    // ... draw here ...
    glFlush();
}
```

---

### 17. **glClearColor()**

**What it does:** Sets the background color

**Why use it:** Defines what color is used when clearing

**When to use:** In init() function

**Syntax:**
```cpp
glClearColor(red, green, blue, alpha);  // Range: 0.0 to 1.0
```

**Example:**
```cpp
void init() {
    glClearColor(0.0, 0.0, 0.0, 0.0);   // Black background
    glClearColor(1.0, 1.0, 1.0, 1.0);   // White background
}
```

---

## Practical Examples

### Complete Program: Drawing a Rectangle

```cpp
#include <GL/glut.h>

void display() {
    // Clear the window
    glClear(GL_COLOR_BUFFER_BIT);
    
    // Set color to blue
    glColor3f(0.0, 0.0, 1.0);
    
    // Draw rectangle using quad
    glBegin(GL_QUADS);
        glVertex2i(100, 100);   // Bottom-left
        glVertex2i(400, 100);   // Bottom-right
        glVertex2i(400, 400);   // Top-right
        glVertex2i(100, 400);   // Top-left
    glEnd();
    
    // Display the result
    glFlush();
}

void init() {
    // Black background
    glClearColor(0.0, 0.0, 0.0, 0.0);
    
    // Set up 2D coordinate system
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluOrtho2D(0.0, 500.0, 0.0, 500.0);
}

int main(int argc, char** argv) {
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
    glutInitWindowSize(500, 500);
    glutInitWindowPosition(100, 100);
    glutCreateWindow("Rectangle Drawing");
    
    init();
    glutDisplayFunc(display);
    glutMainLoop();
    
    return 0;
}
```

---

### Example: Drawing a Triangle

```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    glColor3f(1.0, 0.0, 0.0);  // Red
    
    glBegin(GL_TRIANGLES);
        glVertex2i(250, 400);   // Top
        glVertex2i(100, 100);   // Bottom-left
        glVertex2i(400, 100);   // Bottom-right
    glEnd();
    
    glFlush();
}
```

---

### Example: Drawing Multiple Points with Different Colors

```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    glBegin(GL_POINTS);
        glColor3f(1.0, 0.0, 0.0);  // Red
        glVertex2i(100, 100);
        
        glColor3f(0.0, 1.0, 0.0);  // Green
        glVertex2i(250, 250);
        
        glColor3f(0.0, 0.0, 1.0);  // Blue
        glVertex2i(400, 400);
    glEnd();
    
    glFlush();
}
```

---

### Example: Drawing a Line

```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    glColor3f(1.0, 1.0, 0.0);  // Yellow
    
    glBegin(GL_LINES);
        glVertex2i(50, 50);
        glVertex2i(450, 450);
    glEnd();
    
    glFlush();
}
```

---

### Example: Drawing Connected Lines (Star)

```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    glColor3f(1.0, 1.0, 1.0);  // White
    
    glBegin(GL_LINE_LOOP);  // Closed line loop
        glVertex2i(250, 450);
        glVertex2i(290, 350);
        glVertex2i(400, 350);
        glVertex2i(320, 270);
        glVertex2i(360, 150);
        glVertex2i(250, 220);
        glVertex2i(140, 150);
        glVertex2i(180, 270);
        glVertex2i(100, 350);
        glVertex2i(210, 350);
    glEnd();
    
    glFlush();
}
```

---

## Common Exam Patterns

### Pattern 1: Basic Setup Template

```cpp
#include <GL/glut.h>

void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    // YOUR DRAWING CODE HERE
    
    glFlush();
}

void init() {
    glClearColor(0.0, 0.0, 0.0, 0.0);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluOrtho2D(0.0, 500.0, 0.0, 500.0);
}

int main(int argc, char** argv) {
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
    glutInitWindowSize(500, 500);
    glutInitWindowPosition(100, 100);
    glutCreateWindow("Graphics Window");
    init();
    glutDisplayFunc(display);
    glutMainLoop();
    return 0;
}
```

---

### Pattern 2: Drawing with Point Size

```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    glPointSize(5.0);  // Make points larger
    glColor3f(1.0, 1.0, 1.0);
    
    glBegin(GL_POINTS);
        glVertex2i(250, 250);
        glVertex2i(100, 100);
        glVertex2i(400, 400);
    glEnd();
    
    glFlush();
}
```

---

### Pattern 3: Drawing with Line Width

```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    glLineWidth(3.0);  // Thicker lines
    glColor3f(1.0, 0.0, 0.0);
    
    glBegin(GL_LINES);
        glVertex2i(50, 250);
        glVertex2i(450, 250);
    glEnd();
    
    glFlush();
}
```

---

### Pattern 4: Drawing Concentric Circles (using triangles)

```cpp
void display() {
    glClear(GL_COLOR_BUFFER_BIT);
    
    int center_x = 250, center_y = 250;
    int radius = 100;
    int segments = 50;
    
    glColor3f(1.0, 1.0, 0.0);
    glBegin(GL_TRIANGLE_FAN);
        glVertex2i(center_x, center_y);  // Center point
        
        for(int i = 0; i <= segments; i++) {
            float angle = 2.0f * 3.14159f * i / segments;
            float x = center_x + radius * cos(angle);
            float y = center_y + radius * sin(angle);
            glVertex2f(x, y);
        }
    glEnd();
    
    glFlush();
}
```

---

## Quick Reference: Function Call Order

```
1. glutInit(&argc, argv);
2. glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
3. glutInitWindowSize(500, 500);
4. glutInitWindowPosition(100, 100);  // Optional
5. glutCreateWindow("Title");
6. init();                             // Your initialization
7. glutDisplayFunc(display);
8. glutMainLoop();                     // Never returns
```

---

## Key Points for Exams

**MUST REMEMBER:**
- Always call glutInit() first
- Window size should match gluOrtho2D() range
- Origin (0,0) is at BOTTOM-LEFT in OpenGL
- Always clear buffer at start of display()
- Use glFlush() for GLUT_SINGLE mode
- Use glutSwapBuffers() for GLUT_DOUBLE mode
- Color values: 0.0 (off) to 1.0 (full intensity)
- Every glBegin() needs matching glEnd()

**COMMON MISTAKES:**
- Forgetting glFlush() (nothing appears)
- Wrong coordinate system mapping
- Calling glutMainLoop() in wrong place (blocks forever)
- Not clearing buffer (trails appear)
- Mismatched glBegin()/glEnd() pairs

---

## Compilation Command (Linux/Ubuntu)

```bash
g++ -o program program.cpp -lGL -lGLU -lglut
./program
```

---

## Compilation Command (Windows with MinGW)

```bash
g++ -o program program.cpp -lopengl32 -lglu32 -lglut32
program.exe
```

