#include <GL/glut.h>

void houseBody()
{
  glBegin(GL_QUADS);

  glColor3f(1.0, 0.0, 0.0);
  glVertex2f(-0.8, -0.5);
  glVertex2f(0.8, -0.5);
  glVertex2f(0.8, 0.5);
  glVertex2f(-0.8, 0.5);

  glEnd();
}
void houseDoor()
{
  glBegin(GL_QUADS);

  glColor3f(0.0, 1.0, 0.0);
  glVertex2f(-0.2, -0.5);
  glVertex2f(0.2, -0.5);
  glVertex2f(0.2, 0.0);
  glVertex2f(-0.2, 0.0);

  glEnd();
}
void houseRoof()
{
  glBegin(GL_TRIANGLES);

  glColor3f(0.0, 1.0, 1.0);
  glVertex2f(-0.8, 0.5);
  glVertex2f(0.8, 0.5);
  glVertex2f(0.0, 1.0);

  glEnd();
}

void display()
{
  glClearColor(0.0, 0.0, 0.0, 1.0);
  glClear(GL_COLOR_BUFFER_BIT);

  houseBody();
  houseRoof();
  houseDoor();

  glFlush();
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);

  glutInitWindowSize(800, 800);

  glutCreateWindow("House Art");

  glutDisplayFunc(display);

  glutMainLoop();
}