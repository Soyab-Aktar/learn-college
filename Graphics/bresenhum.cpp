#include <GL/glut.h>
#include <cmath>

// Optimization: Use 'int' instead of 'float' for Bresenham's efficiency
void drawLine(int x1, int y1, int x2, int y2)
{
  int dx = x2 - x1;
  int dy = y2 - y1;

  // Decision parameter
  int p = 2 * dy - dx;

  int x = x1;
  int y = y1;

  glBegin(GL_POINTS);

  // 1. Loop until x equals x2 (<= ensures the last point is drawn)
  while (x <= x2)
  {
    // 2. Draw the pixel first
    glVertex2i(x, y);

    // 3. Update variables for the NEXT pixel
    x++; // x always increases

    if (p >= 0)
    {
      y++;
      p = p + 2 * dy - 2 * dx;
    }
    else
    {
      p = p + 2 * dy;
    }
  }

  glEnd();
}

void display()
{
  glClear(GL_COLOR_BUFFER_BIT);
  glColor3f(1.0, 1.0, 1.0);
  drawLine(50, 50, 300, 300);
  glFlush();
}

void init()
{
  glClearColor(0.0, 0.0, 0.0, 0.0);
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();
  gluOrtho2D(0.0, 500.0, 0.0, 500.0);
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitWindowSize(500, 500);
  glutCreateWindow("Bresenhum Algorithm");
  init();
  glutDisplayFunc(display);
  glutMainLoop();
}