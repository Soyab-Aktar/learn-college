#include <GL/glut.h>

void drawStare()
{
  float steps = 0.3;
  float x = -0.8;
  float y = 0.8;
  glLineWidth(4);
  glBegin(GL_LINES);

  for (int i = 0; i < 4; i++)
  {

    float t = i / 8.0;
    glColor3f(1.0 - t, 1.0 * t, t);
    glVertex2f(x, y);
    glVertex2f(x + steps, y);

    x += steps;

    glVertex2f(x, y);
    glVertex2f(x, y - steps);

    y -= steps;
  }

  glEnd();
}

void display()
{
  glClearColor(0.0, 0.0, 0.0, 1.0);
  glClear(GL_COLOR_BUFFER_BIT);

  drawStare();

  glFlush();
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);

  glutInitWindowSize(500, 500);
  glutCreateWindow("Stare Pattern");

  glutDisplayFunc(display);

  glutMainLoop();

  return 0;
}