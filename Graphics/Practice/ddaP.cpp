#include <GL/glut.h>
#include <cmath>

void drawDDA(float x1, float y1, float x2, float y2)
{
  float dx = x2 - x1;
  float dy = y2 - y1;

  float steps;
  if (abs(dx) > abs(dy))
  {
    steps = abs(dx);
  }
  else
  {
    steps = abs(dy);
  }

  float xInc = dx / steps;
  float yInc = dy / steps;

  float x = x1;
  float y = y1;

  glBegin(GL_POINTS);

  for (int i = 0; i <= steps; i++)
  {
    glVertex2i(round(x), round(y));
    x += xInc;
    y += yInc;
  }

  glEnd();
}

void display()
{
  glClear(GL_COLOR_BUFFER_BIT);
  glColor3f(1.0, 1.0, 1.0);
  drawDDA(50, 50, 350, 350);
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
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);

  glutInitWindowSize(500, 500);
  glutInitWindowPosition(450, 450);
  glutCreateWindow("Re - Vision DDA");

  init();

  glutDisplayFunc(display);

  glutMainLoop();

  return 0;
}
